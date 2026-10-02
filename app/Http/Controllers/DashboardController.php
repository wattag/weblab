<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\Discipline;
use App\Models\Task;
use App\Enums\TaskTypeEnum;
use App\Enums\SubmissionStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function getStudentDisciplineIds($user): array
    {
        if (!$user->group) {
            return [];
        }
        return $user->group->disciplines()->pluck('disciplines.id')->toArray();
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === UserRoleEnum::Teacher) {
            return redirect()->route('teacher.gradebook');
        }
        if ($user->role === UserRoleEnum::Admin) {
            return redirect()->to('/admin');
        }

        $disciplineIds = $this->getStudentDisciplineIds($user);

        $acceptedCount = $user->submissions()->where('status', SubmissionStatusEnum::Accepted)->count();
        $pendingCount = $user->submissions()->where('status', SubmissionStatusEnum::Pending)->count();
        $rejectedCount = $user->submissions()->where('status', SubmissionStatusEnum::Rejected)->count();

        $allPracticeTasks = Task::whereIn('type', [\App\Enums\TaskTypeEnum::Practice, \App\Enums\TaskTypeEnum::Lab, \App\Enums\TaskTypeEnum::Assignment])
            ->whereIn('discipline_id', $disciplineIds)
            ->where(function ($query) use ($user) {
                $query->where('group_id', $user->group_id)
                    ->orWhereNull('group_id');
            })->get();

        $userSubmissions = $user->submissions->keyBy('task_id');
        $totalScore = 0;
        $gradedCount = 0;

        foreach ($allPracticeTasks as $task) {
            $sub = $userSubmissions->get($task->id);
            $isOverdue = $task->deadline_at && $task->deadline_at->isPast();

            if ($sub && is_numeric($sub->grade)) {
                $totalScore += $sub->grade;
                $gradedCount++;
            } elseif ($isOverdue && (!$sub || $sub->status === SubmissionStatusEnum::Rejected)) {
                $totalScore += 2;
                $gradedCount++;
            }
        }

        $averageGrade = $gradedCount > 0 ? round($totalScore / $gradedCount, 2) : 0;

        $deadlineTasksQuery = Task::whereIn('type', [TaskTypeEnum::Practice, TaskTypeEnum::Lab, TaskTypeEnum::Assignment])
            ->whereIn('discipline_id', $disciplineIds)
            ->where(function ($query) use ($user) {
                $query->where('group_id', $user->group_id)
                    ->orWhereNull('group_id');
            })
            ->whereNotNull('deadline_at')
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->whereIn('status', [
                        SubmissionStatusEnum::Accepted,
                        SubmissionStatusEnum::Pending
                    ]);
            });

        $upcomingTasks = (clone $deadlineTasksQuery)->where('deadline_at', '>=', now())->orderBy('deadline_at', 'asc')->take(3)->get();
        $overdueTasks = (clone $deadlineTasksQuery)->where('deadline_at', '<', now())->orderBy('deadline_at', 'desc')->take(3)->get();

        return view('dashboard', compact('averageGrade', 'acceptedCount', 'pendingCount', 'rejectedCount', 'upcomingTasks', 'overdueTasks'));
    }

    public function theory(Request $request)
    {
        return view('theory', $this->getTasksAndDisciplines(
            [TaskTypeEnum::Theory, TaskTypeEnum::Manual],
            $request
        ));
    }

    public function practice(Request $request)
    {
        return view('practice', $this->getTasksAndDisciplines(
            [TaskTypeEnum::Practice, TaskTypeEnum::Lab, TaskTypeEnum::Assignment],
            $request,
            withSubmissions: true
        ));
    }

    /**
     * @return array{tasks: \Illuminate\Support\Collection, disciplines: \Illuminate\Support\Collection}
     */
    private function getTasksAndDisciplines(array $types, Request $request, bool $withSubmissions = false): array
    {
        $user = Auth::user();

        $query = Task::whereIn('type', $types);

        if ($withSubmissions) {
            $query->with(['submissions' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }]);
        }

        if ($user->role === UserRoleEnum::Teacher) {
            $query->where('teacher_id', $user->id);

            $disciplineIds = Task::where('teacher_id', $user->id)
                ->pluck('discipline_id')
                ->unique();

            $disciplines = Discipline::whereIn('id', $disciplineIds)->get();
        } else {
            $disciplines = $user->group?->disciplines ?? collect();
            $disciplineIds = $disciplines->pluck('id')->toArray();

            $query->whereIn('discipline_id', $disciplineIds)
                ->where(function ($q) use ($user) {
                    $q->where('group_id', $user->group_id)
                        ->orWhereNull('group_id');
                });
        }

        if ($request->filled('discipline')) {
            $query->where('discipline_id', $request->discipline);
        }

        $tasks = $query->orderByDesc('created_at')->get();

        return compact('tasks', 'disciplines');
    }

    public function grades()
    {
        $user = Auth::user();

        if ($user->role === UserRoleEnum::Teacher) {
            return redirect()->to('/admin');
        }

        $disciplineIds = $this->getStudentDisciplineIds($user);

        $tasks = Task::whereIn('type', [TaskTypeEnum::Practice, TaskTypeEnum::Lab, TaskTypeEnum::Assignment])
            ->whereIn('discipline_id', $disciplineIds)
            ->where(function ($query) use ($user) {
                $query->where('group_id', $user->group_id)
                    ->orWhereNull('group_id');
            })
            ->with(['submissions' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }, 'discipline'])
            // Сортируем: сначала новые
            ->orderBy('created_at', 'desc')
            ->get();

        return view('grades', compact('tasks'));
    }
}

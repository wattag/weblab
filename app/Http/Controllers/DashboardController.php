<?php

namespace App\Http\Controllers;

use App\Enums\SubmissionStatusEnum;
use App\Enums\TaskTypeEnum;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $acceptedCount = $user->submissions()->where('status', SubmissionStatusEnum::Accepted)->count();
        $pendingCount = $user->submissions()->where('status', SubmissionStatusEnum::Pending)->count();
        $rejectedCount = $user->submissions()->where('status', SubmissionStatusEnum::Rejected)->count();

        $deadlineTasksQuery = Task::where('type', TaskTypeEnum::Practice)
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

        $upcomingTasks = (clone $deadlineTasksQuery)
            ->where('deadline_at', '>=', now())
            ->orderBy('deadline_at', 'asc')
            ->take(3)
            ->get();

        $overdueTasks = (clone $deadlineTasksQuery)
            ->where('deadline_at', '<', now())
            ->orderBy('deadline_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact('acceptedCount', 'pendingCount', 'rejectedCount', 'upcomingTasks', 'overdueTasks'));
    }

    public function theory(): View
    {
        $user = Auth::user();

        $tasks = Task::where(function ($query) use ($user) {
            $query->where('group_id', $user->group_id)
                ->orWhereNull('group_id');
        })
            ->where('type', TaskTypeEnum::Theory)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('theory', compact('tasks'));
    }

    public function practice(): View
    {
        $user = Auth::user();

        $tasks = Task::where(function ($query) use ($user) {
            $query->where('group_id', $user->group_id)
                ->orWhereNull('group_id');
        })
            ->where('type', TaskTypeEnum::Practice)
            ->orderBy('created_at', 'desc')
            ->with(['submissions' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        return view('practice', compact('tasks'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Enums\TaskTypeEnum;
use App\Enums\UserRoleEnum;
use App\Models\Group;
use App\Models\Submission;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function gradebook(Request $request)
    {
        $teacher = Auth::user();

        if ($teacher->role !== UserRoleEnum::Teacher && $teacher->role !== UserRoleEnum::Admin) {
            abort(403);
        }

        // 1. Получаем все группы
        $groups = Group::orderBy('name')->get();

        $selectedGroupId = $request->get('group_id');
        $selectedDisciplineId = $request->get('discipline_id');

        $disciplines = collect();
        $students = collect();
        $tasks = collect();
        $matrix = [];

        if ($selectedGroupId) {
            // 2. Получаем дисциплины, которые изучает выбранная группа
            $group = Group::find($selectedGroupId);
            if ($group) {
                $disciplines = $group->disciplines()->orderBy('name')->get();
            }

            // 3. Если выбрана и группа, и дисциплина — строим матрицу
            if ($selectedDisciplineId) {
                $students = User::where('role', UserRoleEnum::Student)
                    ->where('group_id', $selectedGroupId)
                    ->orderBy('surname')
                    ->get();

                $tasks = Task::where('teacher_id', $teacher->id)
                    ->where('discipline_id', $selectedDisciplineId) // <--- ФИЛЬТР ПО ДИСЦИПЛИНЕ
                    ->whereIn('type', [TaskTypeEnum::Practice, TaskTypeEnum::Lab, TaskTypeEnum::Assignment])
                    ->where(function ($query) use ($selectedGroupId) {
                        $query->where('group_id', $selectedGroupId)
                            ->orWhereNull('group_id');
                    })
                    ->orderBy('created_at')
                    ->get();

                if ($students->isNotEmpty() && $tasks->isNotEmpty()) {
                    $submissions = Submission::whereIn('user_id', $students->pluck('id'))
                        ->whereIn('task_id', $tasks->pluck('id'))
                        ->get();

                    foreach ($submissions as $sub) {
                        $matrix[$sub->user_id][$sub->task_id] = $sub;
                    }
                }
            }
        }

        return view('teacher.gradebook', compact(
            'groups',
            'selectedGroupId',
            'disciplines',
            'selectedDisciplineId',
            'students',
            'tasks',
            'matrix'
        ));
    }}

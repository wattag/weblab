<?php

namespace App\Http\Controllers;

use App\Enums\TaskSubmissionTypeEnum;
use App\Models\Task;
use App\Models\Submission;
use App\Enums\SubmissionStatusEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function show(Task $task)
    {
        $user = Auth::user();

        if ($user->role === UserRoleEnum::Teacher) {
            if ($task->teacher_id !== $user->id) {
                abort(403, 'Вы не можете просматривать задания других преподавателей.');
            }
        } else {
            if ($task->group_id !== null && $task->group_id !== $user->group_id) {
                abort(403, 'Это задание предназначено для другой группы.');
            }

            $disciplineIds = $user->group ? $user->group->disciplines()->pluck('disciplines.id')->toArray() : [];
            if (!in_array($task->discipline_id, $disciplineIds, true)) {
                abort(403, 'У вашей группы нет доступа к этой дисциплине.');
            }
        }

        $submission = $task->submissions()->where('user_id', $user->id)->first();

        return view('tasks.show', compact('task', 'submission'));
    }

    public function submit(Request $request, Task $task)
    {
        $user = Auth::user();

        if ($user->role === UserRoleEnum::Teacher) {
            abort(403, 'Преподаватели не могут сдавать работы.');
        }

        if ($task->group_id !== null && $task->group_id !== $user->group_id) {
            abort(403, 'У вас нет доступа к этому заданию.');
        }

        if ($task->type->isTheoryGroup()) {
            abort(400, 'Это задание не требует сдачи.');
        }

        $submission = $task->submissions()->where('user_id', $user->id)->first();

        if ($submission && in_array($submission->status, [SubmissionStatusEnum::Pending, SubmissionStatusEnum::Accepted])) {
            return back()->withErrors(['error' => 'Вы не можете изменить эту работу прямо сейчас.']);
        }

        $rules = [];
        if ($task->submission_type === TaskSubmissionTypeEnum::Link) {
            $rules['github_url'] = ['required', 'url', 'max:255'];
        } elseif ($task->submission_type === TaskSubmissionTypeEnum::File) {
            $rules['file'] = ['required', 'file', 'max:102400']; // 50MB
        } else {
            $rules['github_url'] = ['nullable', 'required_without:file', 'url', 'max:255'];
            $rules['file'] = ['nullable', 'required_without:github_url', 'file', 'max:102400'];
        }

        $request->validate($rules);

        $filePath = $submission->file_path ?? null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $folderPath = "submissions/{$user->id}/{$task->id}";

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $filePath = $file->storeAs($folderPath, $originalName, 'public');
        }

        if ($submission) {
            $submission->update([
                'github_url' => $request->github_url ?? $submission->github_url,
                'file_path' => $filePath,
                'status' => SubmissionStatusEnum::Pending,
            ]);
        } else {
            Submission::create([
                'user_id' => $user->id,
                'task_id' => $task->id,
                'github_url' => $request->github_url,
                'file_path' => $filePath,
                'status' => SubmissionStatusEnum::Pending,
            ]);
        }

        return back()->with('status', 'Работа успешно отправлена на проверку!');
    }
}

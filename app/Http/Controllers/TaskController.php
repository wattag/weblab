<?php

namespace App\Http\Controllers;

use App\Enums\SubmissionStatusEnum;
use App\Enums\TaskTypeEnum;
use App\Models\Submission;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskController extends Controller
{
    private function userCheck(Task $task): Authenticatable|null|User
    {
        $user = Auth::user();

        if ($task->group_id !== null && $task->group_id !== $user->group_id) {
            abort(403, 'У вас нет доступа к этому заданию.');
        }

        return $user;
    }

    public function show(Task $task): View
    {
        $user = $this->userCheck($task);

        $submission = $task->submissions()->where('user_id', $user->id)->first();

        return view('tasks.show', compact(['task', 'submission']));
    }

    public function submit(Request $request, Task $task): RedirectResponse
    {
        $user = $this->userCheck($task);

        if ($task->type !== TaskTypeEnum::Practice) {
            abort(400, 'Это задание не требует сдачи.');
        }

        $submission = $task->submissions()->where('user_id', $user->id)->first();

        if ($submission && in_array($submission->status, [SubmissionStatusEnum::Pending, SubmissionStatusEnum::Accepted], true)) {
            return back()->withErrors(['error' => 'Вы не можете изменить эту работу прямо сейчас.']);
        }

        $request->validate([
            'github_url' => [
                'required',
                'url',
                'max:255'
            ],
        ]);

        if ($submission) {
            $submission->update([
                'github_url' => $request->github_url,
                'status' => SubmissionStatusEnum::Pending,
            ]);
        } else {
            Submission::create([
                'user_id' => $user->id,
                'task_id' => $task->id,
                'github_url' => $request->github_url,
                'status' => SubmissionStatusEnum::Pending,
            ]);
        }

        return back()->with('status', 'Работа успешно отправлена на проверку!');
    }

}



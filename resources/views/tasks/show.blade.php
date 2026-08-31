@php
    use App\Enums\TaskSubmissionTypeEnum;
    use App\Enums\SubmissionStatusEnum;
    use App\Enums\UserRoleEnum;use Illuminate\Support\Str;

    $isTheory = $task->type->isTheoryGroup();
    $accentColor = $isTheory ? 'cyan' : 'emerald';
@endphp

@extends('layouts.main')
@section('title', $task->title . ' - ' . config('app.name', 'WebLab'))

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:py-10">

        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-{{ $accentColor }}-500 mb-8 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Назад к списку
        </a>

        <div
            class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 p-6 sm:p-10 mb-8">
            <div
                class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8 pb-8 border-b-2 border-slate-100 dark:border-slate-800/50">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mb-4 leading-tight">
                        {{ $task->title }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm font-bold text-slate-500 dark:text-slate-400">
                        <span
                            class="inline-flex items-center gap-1.5 text-{{ $accentColor }}-600 dark:text-{{ $accentColor }}-400 bg-{{ $accentColor }}-50 dark:bg-{{ $accentColor }}-500/10 px-3 py-1 rounded-lg border border-{{ $accentColor }}-200 dark:border-{{ $accentColor }}-500/20">
                            {{ $task->type->getLabel() }}
                        </span>

                        @if($task->deadline_at)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                                               d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Дедлайн: {{ $task->deadline_at->format('d.m.Y H:i') }}
                            </span>
                        @endif
                    </div>
                </div>

                @if(!$isTheory && auth()->user()->role === UserRoleEnum::Student)
                    <div class="shrink-0 mt-2 md:mt-0">
                        @if($submission)
                            @php
                                if ($submission->status === SubmissionStatusEnum::Accepted) {
                                    $badgeClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/30';
                                } elseif ($submission->status === SubmissionStatusEnum::Rejected) {
                                    $badgeClass = 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 border-red-200 dark:border-red-500/30';
                                } else {
                                    $badgeClass = 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border-amber-200 dark:border-amber-500/30';
                                }
                            @endphp
                            <span class="inline-flex px-4 py-2 text-sm font-bold rounded-xl border-2 {{ $badgeClass }}">
                                {{ $submission->status->getLabel() }}
                            </span>
                        @else
                            <span
                                class="inline-flex px-4 py-2 text-sm font-bold rounded-xl border-2 bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border-slate-200 dark:border-slate-700">
                                Не сдано
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <div
                class="prose prose-slate dark:prose-invert prose-headings:font-black prose-a:text-violet-500 hover:prose-a:text-violet-400 max-w-none text-slate-700 dark:text-slate-300">
                {!! Str::markdown($task->content ?? 'Описание отсутствует.') !!}
            </div>
        </div>

        <!-- Сдача работы -->
        @if(!$isTheory && auth()->user()->role === UserRoleEnum::Student)
            <div
                class="bg-white dark:bg-slate-800/80 rounded-3xl border-2 border-slate-200 dark:border-slate-700 p-6 sm:p-10 shadow-lg shadow-slate-900/5">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-6">Сдача работы</h2>

                @if(session('status'))
                    <div
                        class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border-2 border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-sm font-bold flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div
                        class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-500/10 border-2 border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 text-sm font-bold">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($submission)
                    <div
                        class="mb-8 p-6 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-slate-800">
                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4">Текущее отправленное
                            решение:</p>

                        <div class="flex flex-col gap-3">
                            @if($submission->github_url)
                                <a href="{{ $submission->github_url }}" target="_blank"
                                   class="font-bold text-violet-600 dark:text-violet-400 hover:underline break-all flex items-center gap-2">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    {{ $submission->github_url }}
                                </a>
                            @endif

                            @if($submission->file_path)
                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
                                   class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline break-all flex items-center gap-2">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                    </svg>
                                    Прикрепленный файл (Скачать)
                                </a>
                            @endif
                        </div>

                        @if($submission->teacher_comment)
                            <div class="mt-6 pt-6 border-t-2 border-slate-200 dark:border-slate-800/50">
                                <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                    Комментарий преподавателя:
                                </p>
                                <p class="text-slate-800 dark:text-slate-200 text-base font-medium bg-white dark:bg-slate-950 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
                                    {{ $submission->teacher_comment }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                @if(!$submission || $submission->status === SubmissionStatusEnum::Rejected)
                    <form action="{{ route('tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            @if(in_array($task->submission_type, [TaskSubmissionTypeEnum::Link, TaskSubmissionTypeEnum::Any], true))
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Ссылка
                                        на решение</label>
                                    <input type="url" name="github_url" value="{{ $submission?->github_url }}"
                                           placeholder="https://github.com/..."
                                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                                </div>
                            @endif

                            @if(in_array($task->submission_type, [TaskSubmissionTypeEnum::File, TaskSubmissionTypeEnum::Any], true))
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Прикрепить
                                        файл</label>
                                    <input type="file" name="file"
                                           class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-violet-50 file:text-violet-700 dark:file:bg-violet-900/30 dark:file:text-violet-400 hover:file:bg-violet-100 transition-colors border-2 border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950 cursor-pointer">
                                </div>
                            @endif
                        </div>

                        <div class="mt-8">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex justify-center py-3.5 px-8 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 active:border-b-0 active:translate-y-1 transition-all text-center shadow-lg shadow-violet-900/20">
                                {{ $submission ? 'Отправить исправленное решение' : 'Отправить на проверку' }}
                            </button>
                        </div>
                    </form>
                @elseif($submission->status === SubmissionStatusEnum::Pending)
                    <div
                        class="p-5 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border-2 border-amber-200 dark:border-amber-500/20 text-amber-800 dark:text-amber-400 text-sm font-bold flex items-start gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Работа находится на проверке. Вы не можете изменить решение до получения ответа от
                        преподавателя.
                    </div>
                @else
                    <div
                        class="p-5 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border-2 border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-sm font-bold flex items-center gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Работа зачтена! Редактирование больше недоступно.
                    </div>
                @endif
            </div>
        @endif

    </div>
@endsection

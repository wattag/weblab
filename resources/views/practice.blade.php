@php
    use App\Enums\SubmissionStatusEnum;
    use App\Enums\TaskTypeEnum;

    $completedTasks = $tasks->filter(function($task) {
        $sub = $task->submissions->first();
        return $sub && $sub->status === SubmissionStatusEnum::Accepted;
    });

    $activeTasks = $tasks->reject(function($task) {
        $sub = $task->submissions->first();
        return $sub && $sub->status === SubmissionStatusEnum::Accepted;
    });

    $groupedActiveTasks = $activeTasks->groupBy(fn($task) => $task->type->value);
    $groupedCompletedTasks = $completedTasks->groupBy(fn($task) => $task->type->value);
@endphp

@extends('layouts.main')
@section('title', 'Практика - ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full">

        <div class="flex items-center gap-4 mb-10 pb-8 border-b-2 border-slate-200 dark:border-slate-800">
            <div class="w-16 h-16 rounded-2xl bg-emerald-600 border-b-4 border-emerald-800 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-emerald-900/20">
                {{ mb_substr(auth()->user()->getFullName(), 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white">{{ auth()->user()->getFullName() }}</h1>
                <p class="text-slate-500 dark:text-slate-400 font-bold mt-1">
                    Группа: <span class="text-emerald-500">{{ auth()->user()->group?->name ?? 'Не указана' }}</span>
                </p>
            </div>
        </div>

        @if($disciplines->isNotEmpty())
            <div class="flex flex-wrap items-center gap-3 mb-8">
                <a href="{{ route('practice') }}" class="px-5 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all duration-200 active:scale-95 {{ !request('discipline') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800/50 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800' }}">
                    Все предметы
                </a>

                @foreach($disciplines as $discipline)
                    <a href="{{ route('practice', ['discipline' => $discipline->id]) }}" class="px-5 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all duration-200 active:scale-95 {{ request('discipline') == $discipline->id ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800/50 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800' }}">
                        {{ $discipline->name }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($tasks->isEmpty())
            <div class="py-12 text-center bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Заданий нет</h3>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">Преподаватель пока не загрузил лабы для вашей группы.</p>
            </div>
        @else

            @if($activeTasks->isNotEmpty())
                <div x-data="{ open: true }" class="mb-14">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-2xl font-black text-slate-800 dark:text-white mb-6 group outline-none">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border-2 border-emerald-500/20 flex items-center justify-center text-emerald-500 transition-colors group-hover:bg-emerald-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            К выполнению
                            <span class="ml-2 px-3 py-1 bg-emerald-500/10 text-emerald-500 text-sm font-bold rounded-lg border border-emerald-500/20">{{ $activeTasks->count() }}</span>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition-colors">
                            <svg :class="{'rotate-180': open}" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">

                        <div class="flex flex-col gap-10">
                            @foreach($groupedActiveTasks as $typeValue => $tasksGroup)
                                <div>
                                    <h3 class="text-lg font-bold text-slate-600 dark:text-slate-300 mb-4 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        {{ TaskTypeEnum::from($typeValue)->getLabel() }}
                                        <span class="text-sm font-bold text-slate-400 dark:text-slate-500 ml-1">({{ $tasksGroup->count() }})</span>
                                    </h3>

                                    <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6">
                                        @foreach($tasksGroup as $task)
                                            @include('partials.practice-card', ['task' => $task, 'isCompleted' => false])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif

            @if($completedTasks->isNotEmpty())
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-2xl font-black text-slate-800 dark:text-white mb-6 group outline-none">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-500/10 border-2 border-slate-500/20 flex items-center justify-center text-emerald-500 transition-colors group-hover:bg-slate-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            Выполненные задания
                            <span class="ml-2 px-3 py-1 bg-emerald-500/10 text-emerald-500 text-sm font-bold rounded-lg border border-emerald-500/20">{{ $completedTasks->count() }}</span>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition-colors">
                            <svg :class="{'rotate-180': open}" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" style="display: none;">

                        <!-- Группировка по типам -->
                        <div class="flex flex-col gap-10">
                            @foreach($groupedCompletedTasks as $typeValue => $tasksGroup)
                                <div>
                                    <h3 class="text-lg font-bold text-slate-600 dark:text-slate-400 mb-4 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-600"></span>
                                        {{ TaskTypeEnum::from($typeValue)->getLabel() }}
                                        <span class="text-sm font-bold text-slate-400 dark:text-slate-500 ml-1">({{ $tasksGroup->count() }})</span>
                                    </h3>

                                    <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6">
                                        @foreach($tasksGroup as $task)
                                            @include('partials.practice-card', ['task' => $task, 'isCompleted' => true])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif

        @endif
    </div>
@endsection

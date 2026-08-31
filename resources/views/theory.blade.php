@php
    use App\Enums\TaskTypeEnum;

    $lectures = $tasks->where('type', TaskTypeEnum::Theory);
    $manuals = $tasks->where('type', TaskTypeEnum::Manual);
@endphp

@extends('layouts.main')
@section('title', 'Теория | ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full">

        <div class="flex items-center gap-4 mb-10 pb-8 border-b-2 border-slate-200 dark:border-slate-800">
            <div class="w-16 h-16 rounded-2xl bg-indigo-600 border-b-4 border-indigo-800 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-indigo-900/20">
                {{ mb_substr(auth()->user()->getFullName(), 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white">{{ auth()->user()->getFullName() }}</h1>
                <p class="text-slate-500 dark:text-slate-400 font-bold mt-1">
                    Группа: <span class="text-indigo-500">{{ auth()->user()->group?->name ?? 'Не указана' }}</span>
                </p>
            </div>
        </div>

        @if($disciplines->isNotEmpty())
            <div class="flex flex-wrap items-center gap-3 mb-8">
                <a href="{{ route('theory') }}" class="px-5 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all duration-200 active:scale-95 {{ !request('discipline') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-500/30' : 'bg-slate-100 dark:bg-slate-800/50 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800' }}">
                    Все предметы
                </a>

                @foreach($disciplines as $discipline)
                    <a href="{{ route('theory', ['discipline' => $discipline->id]) }}" class="px-5 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all duration-200 active:scale-95 {{ request('discipline') == $discipline->id ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-500/30' : 'bg-slate-100 dark:bg-slate-800/50 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800' }}">
                        {{ $discipline->name }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($tasks->isEmpty())
            <div class="py-12 text-center bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Теории пока нет</h3>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">Преподаватель не добавил методички для вашей группы.</p>
            </div>
        @else

            <!-- БЛОК 1: ЛЕКЦИИ -->
            @if($lectures->isNotEmpty())
                <div x-data="{ open: true }" class="mb-14">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-2xl font-black text-slate-800 dark:text-white mb-6 group outline-none">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border-2 border-indigo-500/20 flex items-center justify-center text-indigo-500 transition-colors group-hover:bg-indigo-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            </div>
                            Лекции
                            <!-- Счетчик лекций -->
                            <span class="ml-2 px-3 py-1 bg-indigo-500/10 text-indigo-500 text-sm font-bold rounded-lg border border-indigo-500/20">{{ $lectures->count() }}</span>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center text-slate-400 group-hover:text-indigo-500 transition-colors">
                            <svg :class="{'rotate-180': open}" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
                        <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6">
                            @foreach($lectures as $task)
                                <div class="flex flex-col bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 hover:-translate-y-1 hover:border-indigo-400 dark:hover:border-indigo-500 hover:shadow-xl hover:shadow-indigo-900/10 transition-all duration-300 overflow-hidden group">
                                    <div class="px-6 py-4 border-b-2 border-slate-100 dark:border-slate-800/50 flex justify-between items-center bg-indigo-50/50 dark:bg-indigo-500/5">
                                        <span class="text-xs font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400">{{ $task->type->getLabel() }}</span>
                                    </div>
                                    <div class="p-6 flex-grow flex flex-col justify-center">
                                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2 line-clamp-3 group-hover:text-indigo-500 transition-colors">
                                            {{ $task->title }}
                                        </h3>
                                    </div>
                                    <div class="p-5 bg-slate-50 dark:bg-slate-800/30 border-t-2 border-slate-100 dark:border-slate-800/50">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="w-full flex justify-center py-3 px-4 border-2 border-indigo-500 border-b-4 border-b-indigo-700 bg-indigo-600 text-white text-sm font-black uppercase tracking-wider rounded-xl hover:bg-indigo-500 active:border-b-0 active:translate-y-1 transition-all shadow-sm">
                                            Читать материал
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- БЛОК 2: МАНУАЛЫ -->
            @if($manuals->isNotEmpty())
                <div x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-2xl font-black text-slate-800 dark:text-white mb-6 group outline-none">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border-2 border-indigo-500/20 flex items-center justify-center text-indigo-500 transition-colors group-hover:bg-indigo-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            </div>
                            Инструкции
                            <!-- Счетчик мануалов -->
                            <span class="ml-2 px-3 py-1 bg-indigo-500/10 text-indigo-500 text-sm font-bold rounded-lg border border-indigo-500/20">{{ $manuals->count() }}</span>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center text-slate-400 group-hover:text-indigo-500 transition-colors">
                            <svg :class="{'rotate-180': open}" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
                        <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6">
                            @foreach($manuals as $task)
                                <div class="flex flex-col bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 hover:-translate-y-1 hover:border-indigo-400 dark:hover:border-indigo-500 hover:shadow-xl hover:shadow-indigo-900/10 transition-all duration-300 overflow-hidden group">
                                    <div class="px-6 py-4 border-b-2 border-slate-100 dark:border-slate-800/50 flex justify-between items-center bg-indigo-50/50 dark:bg-indigo-500/5">
                                        <span class="text-xs font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400">{{ $task->type->getLabel() }}</span>
                                    </div>
                                    <div class="p-6 flex-grow flex flex-col justify-center">
                                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2 line-clamp-3 group-hover:text-indigo-500 transition-colors">
                                            {{ $task->title }}
                                        </h3>
                                    </div>
                                    <div class="p-5 bg-slate-50 dark:bg-slate-800/30 border-t-2 border-slate-100 dark:border-slate-800/50">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="w-full flex justify-center py-3 px-4 border-2 border-indigo-500 border-b-4 border-b-indigo-700 bg-indigo-600 text-white text-sm font-black uppercase tracking-wider rounded-xl hover:bg-indigo-500 active:border-b-0 active:translate-y-1 transition-all shadow-sm">
                                            Читать инструкцию
                                        </a>
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

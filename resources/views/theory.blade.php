@extends('layouts.main')
@section('title', 'Теория - ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full">

        <div class="flex items-center gap-4 mb-10 pb-8 border-b-2 border-slate-200 dark:border-slate-800">
            <div class="w-16 h-16 rounded-2xl bg-indigo-600 border-b-4 border-indigo-800 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-indigo-900/20">
                {{ mb_substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white">{{ auth()->user()->getFullName() }}</h1>
                <p class="text-slate-500 dark:text-slate-400 font-bold mt-1">
                    Группа: <span class="text-indigo-500">{{ auth()->user()->group?->name ?? 'Не указана' }}</span>
                </p>
            </div>
        </div>

        @if($tasks->isEmpty())
            <div class="py-12 text-center bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Теории пока нет</h3>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">Преподаватель не добавил методички для вашей группы.</p>
            </div>
        @else
            <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border-2 border-indigo-500/20 flex items-center justify-center text-indigo-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </div>
                Теория
            </h2>

            <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6">
                @foreach($tasks as $task)
                    <div class="flex flex-col bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 hover:-translate-y-1 hover:border-indigo-400 dark:hover:border-indigo-500 hover:shadow-xl hover:shadow-indigo-900/10 transition-all duration-300 overflow-hidden group">
                        <div class="px-6 py-4 border-b-2 border-slate-100 dark:border-slate-800/50 flex justify-between items-center bg-indigo-50/50 dark:bg-indigo-500/5">
                            <span class="text-xs font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Лекция</span>
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
        @endif
    </div>
@endsection

@extends('layouts.main')

@section('title', 'Мой профиль - ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full">
        <h1 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mb-8">Мой профиль</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            <div class="bg-violet-600 rounded-3xl border-2 border-violet-500 border-b-4 border-b-violet-800 p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 relative overflow-hidden shadow-xl shadow-violet-900/20">

                <div class="w-24 h-24 shrink-0 rounded-3xl bg-white border-b-4 border-slate-300 flex items-center justify-center text-violet-600 text-4xl font-black z-10">
                    {{ mb_substr(auth()->user()->getFullName(), 0, 1) }}
                </div>

                <div class="flex-1 text-center sm:text-left z-10">
                    <h2 class="text-2xl sm:text-3xl font-black text-white mb-2">{{ auth()->user()->getFullName() }}</h2>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-violet-800/50 border border-violet-500/50 text-violet-100 text-sm font-bold mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Группа: {{ auth()->user()->group?->name ?? 'Не указана' }}
                    </div>
                    <p class="text-violet-200 font-medium">{{ auth()->user()->email }}</p>
                </div>

                <div class="mt-4 sm:mt-0 z-10 w-full sm:w-auto flex justify-center">
                    <a href="{{ route('profile.edit') }}" class="px-5 py-3 bg-violet-800 hover:bg-violet-700 border-2 border-violet-500 border-b-4 border-b-violet-900 rounded-2xl text-white text-sm font-black uppercase tracking-wide active:border-b-0 active:translate-y-1 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Настройки
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 p-6 sm:p-8 flex flex-col">
                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Дедлайны
                </h3>

                <div class="flex flex-col gap-3 flex-grow">
                    @if($overdueTasks->isNotEmpty() || $upcomingTasks->isNotEmpty())

                        @foreach($overdueTasks as $task)
                            <a href="{{ route('tasks.show', $task->id) }}" class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/10 border-2 border-red-200 dark:border-red-900/50 hover:border-red-400 dark:hover:border-red-500 hover:-translate-y-1 transition-all group">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1 group-hover:text-red-500 transition-colors">{{ $task->title }}</h4>
                                <p class="text-xs font-bold text-red-600 dark:text-red-500 mt-1">Просрочено: {{ $task->deadline_at->diffForHumans() }}</p>
                            </a>
                        @endforeach

                        @foreach($upcomingTasks as $task)
                            <a href="{{ route('tasks.show', $task->id) }}" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-800 hover:border-rose-400 dark:hover:border-rose-500 hover:-translate-y-1 transition-all group">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1 group-hover:text-rose-500 transition-colors">{{ $task->title }}</h4>
                                <p class="text-xs font-bold text-orange-500 mt-1">Сдать до: {{ $task->deadline_at->format('d.m.Y') }}</p>
                            </a>
                        @endforeach

                    @else
                        <div class="flex-grow flex flex-col items-center justify-center text-center px-2 py-4">
                            <svg class="w-10 h-10 text-emerald-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold text-slate-500 dark:text-slate-400">Всё сдано! Вы можете спать спокойно.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-6">Прогресс обучения</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-emerald-200 dark:border-emerald-900/50 border-b-4 p-6 flex items-center gap-5 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-900/10 transition-all cursor-default">
                <div class="w-16 h-16 shrink-0 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-500 border-2 border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Зачтено</p>
                    <p class="text-4xl font-black text-slate-800 dark:text-white mt-1">{{ $acceptedCount }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-amber-200 dark:border-amber-900/50 border-b-4 p-6 flex items-center gap-5 hover:-translate-y-1 hover:shadow-lg hover:shadow-amber-900/10 transition-all cursor-default">
                <div class="w-16 h-16 shrink-0 rounded-2xl bg-amber-100 dark:bg-amber-500/20 text-amber-500 border-2 border-amber-200 dark:border-amber-500/30 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">На проверке</p>
                    <p class="text-4xl font-black text-slate-800 dark:text-white mt-1">{{ $pendingCount }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-red-200 dark:border-red-900/50 border-b-4 p-6 flex items-center gap-5 hover:-translate-y-1 hover:shadow-lg hover:shadow-red-900/10 transition-all cursor-default">
                <div class="w-16 h-16 shrink-0 rounded-2xl bg-red-100 dark:bg-red-500/20 text-red-500 border-2 border-red-200 dark:border-red-500/30 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Доработки</p>
                    <p class="text-4xl font-black text-slate-800 dark:text-white mt-1">{{ $rejectedCount }}</p>
                </div>
            </div>

        </div>
    </div>
@endsection

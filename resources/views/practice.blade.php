@php use App\Enums\SubmissionStatusEnum; @endphp
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

        @if($tasks->isEmpty())
            <div class="py-12 text-center bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Заданий нет</h3>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">Преподаватель пока не загрузил лабы для вашей группы.</p>
            </div>
        @else
            <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border-2 border-emerald-500/20 flex items-center justify-center text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                </div>
                Практические работы
            </h2>

            <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6">
                @foreach($tasks as $task)
                    @php
                        $submission = $task->submissions->first();

                        $badgeClass = 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border-slate-200 dark:border-slate-700';
                        $btnText = 'Сдать работу';

                        if ($submission) {
                            if ($submission->status === SubmissionStatusEnum::Accepted) {
                                $badgeClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/30';
                                $btnText = 'Просмотр';
                            } elseif ($submission->status === SubmissionStatusEnum::Rejected) {
                                $badgeClass = 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 border-red-200 dark:border-red-500/30';
                                $btnText = 'Исправить решение';
                            } else {
                                $badgeClass = 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border-amber-200 dark:border-amber-500/30';
                                $btnText = 'Открыть задание';
                            }
                        }
                    @endphp

                    <div class="flex flex-col bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 hover:-translate-y-1 hover:border-emerald-400 dark:hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-900/10 transition-all duration-300 overflow-hidden group">

                        <div class="px-5 py-3 border-b-2 border-slate-100 dark:border-slate-800/50 flex justify-between items-center bg-slate-50 dark:bg-slate-800/30">
                            <span class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">Практика</span>
                            <span class="px-3 py-1 text-xs font-bold rounded-lg border {{ $badgeClass }}">
                                {{ $submission ? $submission->status->getLabel() : 'Не сдано' }}
                            </span>
                        </div>

                        <div class="p-6 flex-grow flex flex-col">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4 line-clamp-2 group-hover:text-emerald-500 transition-colors">
                                {{ $task->title }}
                            </h3>

                            <div class="mt-2 mb-4 inline-flex items-center gap-1.5 text-sm font-black {{ $submission?->grade ? 'text-emerald-500' : 'text-slate-400 dark:text-slate-500' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                Оценка: {{ $submission?->grade ?? 'Отсутствует' }}
                            </div>

                            <div class="mt-auto text-sm font-bold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Дедлайн: {{ $task->deadline_at?->format('d.m.Y H:i') ?? 'Без дедлайна' }}
                            </div>
                        </div>

                        <div class="p-5 bg-slate-50 dark:bg-slate-800/30 border-t-2 border-slate-100 dark:border-slate-800/50">
                            <a href="{{ route('tasks.show', $task->id) }}" class="w-full flex justify-center py-3 px-4 border-2 rounded-xl text-sm font-black uppercase tracking-wider active:border-b-0 active:translate-y-1 transition-all shadow-sm border-emerald-500 border-b-emerald-700 bg-emerald-600 hover:bg-emerald-500 text-white">
                                {{ $btnText }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

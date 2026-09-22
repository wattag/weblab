@php use App\Enums\SubmissionStatusEnum; @endphp
@extends('layouts.main')
@section('title', 'Журнал оценок | ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 rounded-2xl bg-amber-600 border-b-4 border-amber-800 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-amber-900/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path></svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white">Журнал преподавателя</h1>
                <p class="text-slate-500 dark:text-slate-400 font-bold mt-1">
                    Сводная таблица успеваемости ваших групп
                </p>
            </div>
        </div>

        <!-- 1. Фильтр Групп (Amber) -->
        <div class="mb-4">
            <p class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">1. Выберите группу</p>
            <div class="flex flex-wrap items-center gap-3">
                @foreach($groups as $group)
                    <a href="{{ route('teacher.gradebook', ['group_id' => $group->id]) }}" class="px-5 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all duration-200 active:scale-95 {{ $selectedGroupId == $group->id ? 'bg-amber-500 text-amber-950 shadow-lg shadow-amber-500/30 border-2 border-amber-400' : 'bg-slate-100 dark:bg-slate-800/50 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800 border-2 border-transparent' }}">
                        {{ $group->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 2. Фильтр Дисциплин (Cyan) - Показывается только если выбрана группа -->
        @if($selectedGroupId && $disciplines->isNotEmpty())
            <div class="mb-8 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-slate-800">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">2. Выберите дисциплину</p>
                <div class="flex flex-wrap items-center gap-3">
                    @foreach($disciplines as $discipline)
                        <a href="{{ route('teacher.gradebook', ['group_id' => $selectedGroupId, 'discipline_id' => $discipline->id]) }}" class="px-5 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all duration-200 active:scale-95 {{ $selectedDisciplineId == $discipline->id ? 'bg-cyan-500 text-cyan-950 shadow-lg shadow-cyan-500/30 border-2 border-cyan-400' : 'bg-white dark:bg-slate-800 text-slate-500 border-2 border-slate-200 dark:border-slate-700 hover:border-cyan-500/50 hover:text-cyan-500' }}">
                            {{ $discipline->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @elseif($selectedGroupId && $disciplines->isEmpty())
            <div class="mb-8 p-4 rounded-2xl bg-rose-50 dark:bg-rose-500/10 border-2 border-rose-200 dark:border-rose-500/20 text-rose-600 dark:text-rose-400 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                К этой группе пока не привязана ни одна дисциплина. (Настройте это в Админке)
            </div>
        @endif

        <!-- СОСТОЯНИЯ ПУСТЫХ СТРАНИЦ -->
        @if(!$selectedGroupId)
            <div class="py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"></path></svg>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Выберите группу</h3>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">Сначала выберите группу, а затем дисциплину.</p>
            </div>
        @elseif($selectedGroupId && !$selectedDisciplineId && $disciplines->isNotEmpty())
            <div class="py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path></svg>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Выберите дисциплину</h3>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">Нажмите на предмет выше, чтобы загрузить матрицу оценок.</p>
            </div>
        @elseif($selectedGroupId && $selectedDisciplineId && ($students->isEmpty() || $tasks->isEmpty()))
            <div class="py-12 text-center bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800">
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Недостаточно данных</h3>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">Либо в группе нет студентов, либо вы еще не создали практических заданий по этому предмету.</p>
            </div>
        @elseif($selectedGroupId && $selectedDisciplineId)
            <!-- МАТРИЦА (ЖУРНАЛ) -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 shadow-xl shadow-slate-900/5 relative">

                <div class="overflow-x-auto rounded-3xl pb-2 custom-scrollbar">
                    <table class="w-full text-left border-collapse min-w-max">
                        <thead>
                        <tr>
                            <th class="sticky left-0 z-20 bg-slate-50 dark:bg-slate-800/95 border-b-2 border-slate-200 dark:border-slate-700 px-6 py-5 shadow-[4px_0_10px_-5px_rgba(0,0,0,0.1)]">
                                <span class="text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">Студент</span>
                            </th>

                            @foreach($tasks as $task)
                                <th class="px-6 py-5 border-b-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 border-l border-slate-100 dark:border-slate-800/50 align-top min-w-[200px] max-w-[250px]">
                                    <p class="text-xs font-black text-slate-400 mb-1 uppercase tracking-wider">{{ $task->deadline_at ? 'До ' . $task->deadline_at->format('d.m') : 'Без срока' }}</p>
                                    <p class="text-sm font-bold text-slate-800 dark:text-white line-clamp-2" title="{{ $task->title }}">
                                        {{ $task->title }}
                                    </p>
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-slate-100 dark:divide-slate-800/50">
                        @foreach($students as $student)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 group">
                                <!-- Имя студента -->
                                <td class="sticky left-0 z-10 bg-white dark:bg-slate-900 group-hover:bg-slate-50 dark:group-hover:bg-slate-800 px-6 py-4 font-bold text-slate-800 dark:text-white shadow-[4px_0_10px_-5px_rgba(0,0,0,0.1)] transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black text-slate-500">
                                            {{ mb_substr($student->surname, 0, 1) }}{{ mb_substr($student->name, 0, 1) }}
                                        </div>
                                        <span class="whitespace-nowrap">{{ $student->surname }} {{ $student->name }}</span>
                                    </div>
                                </td>

                                <!-- Ячейки с оценками -->
                                @foreach($tasks as $task)
                                    @php
                                        $submission = $matrix[$student->id][$task->id] ?? null;
                                        $isOverdue = !$submission && $task->deadline_at && $task->deadline_at->isPast();
                                    @endphp

                                    <td class="border-l border-slate-100 dark:border-slate-800/50 p-2 text-center transition-colors">
                                        @if($submission)
                                            @php
                                                $editUrl = route('filament.admin.resources.submissions.edit', $submission->id);
                                            @endphp
                                            <a href="{{ $editUrl }}" target="_blank" class="block w-full h-full rounded-xl p-3 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                                @if($submission->status === SubmissionStatusEnum::Pending)
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-xs font-bold">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Проверить
                                                        </span>
                                                @elseif($submission->status === SubmissionStatusEnum::Rejected)
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-xs font-bold">
                                                            Доработка
                                                        </span>
                                                @elseif($submission->grade)
                                                    <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">{{ $submission->grade }}</span>
                                                @else
                                                    <span class="text-sm font-black text-emerald-600 dark:text-emerald-400">Зачтено</span>
                                                @endif
                                            </a>
                                        @else
                                            <div class="p-3">
                                                @if($isOverdue)
                                                    <span class="text-xs font-bold text-rose-500">Пропуск</span>
                                                @else
                                                    <span class="text-slate-300 dark:text-slate-600 font-bold">—</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

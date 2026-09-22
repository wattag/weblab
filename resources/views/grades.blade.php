@php
    use App\Enums\SubmissionStatusEnum;
@endphp

@extends('layouts.main')
@section('title', 'Журнал оценок - ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-violet-500 mb-8 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Назад в профиль
        </a>

        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-xl bg-violet-500/10 border-2 border-violet-500/20 flex items-center justify-center text-violet-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path></svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white">Журнал успеваемости</h1>
                <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mt-1">Все ваши  работы</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 overflow-hidden shadow-lg shadow-slate-900/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b-2 border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">Дисциплина</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">Задание</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">Срок сдачи</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">Статус</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 text-center">Оценка</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100 dark:divide-slate-800/50">
                    @forelse($tasks as $task)
                        @php
                            $submission = $task->submissions->first();
                            $isOverdue = $task->deadline_at && $task->deadline_at->isPast();

                            if ($submission) {
                                if ($submission->status === SubmissionStatusEnum::Accepted) {
                                    $statusText = 'Зачтено';
                                    $statusClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/30';
                                } elseif ($submission->status === SubmissionStatusEnum::Rejected) {
                                    $statusText = 'Доработка';
                                    $statusClass = 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 border-red-200 dark:border-red-500/30';
                                } else {
                                    $statusText = 'На проверке';
                                    $statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border-amber-200 dark:border-amber-500/30';
                                }
                            } else {
                                if ($isOverdue) {
                                    $statusText = 'Пропущено';
                                    $statusClass = 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400 border-rose-200 dark:border-rose-500/30';
                                } else {
                                    $statusText = 'Не сдано';
                                    $statusClass = 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border-slate-200 dark:border-slate-700';
                                }
                            }
                        @endphp

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
                            <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                        {{ $task->discipline?->name ?? 'Без предмета' }}
                                    </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('tasks.show', $task->id) }}" class="font-bold text-slate-800 dark:text-white hover:text-violet-600 dark:hover:text-violet-400 transition-colors line-clamp-2">
                                    {{ $task->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @if($task->deadline_at)
                                    <span class="text-sm font-bold {{ $isOverdue && !$submission ? 'text-rose-500' : 'text-slate-500 dark:text-slate-400' }}">
                                            {{ $task->deadline_at->format('d.m.y H:i') }}
                                        </span>
                                @else
                                    <span class="text-sm font-bold text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-lg border whitespace-nowrap {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($submission && $submission->grade)
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-black text-sm border-2 border-emerald-200 dark:border-emerald-500/30">
                                            {{ $submission->grade }}
                                        </span>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600 font-bold">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-sm font-bold text-slate-500 dark:text-slate-400">У вас пока нет практических работ.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

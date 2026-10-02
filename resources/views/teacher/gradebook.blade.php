@php
    use App\Enums\SubmissionStatusEnum;
@endphp

@extends('layouts.main')

@section('title', 'Журнал оценок | ' . config('app.name', 'WebLab'))

@section('content')

    <style>
        /*
        |--------------------------------------------------------------------------
        | Gradebook scrollbar
        |--------------------------------------------------------------------------
        */

        .gradebook-scroll {
            scrollbar-width: thin;
            scrollbar-color: #64748b transparent;
            -webkit-overflow-scrolling: touch;
        }

        .gradebook-scroll::-webkit-scrollbar {
            height: 10px;
        }

        .gradebook-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .gradebook-scroll::-webkit-scrollbar-thumb {
            background: #64748b;
            border-radius: 9999px;
        }

        .gradebook-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark .gradebook-scroll {
            scrollbar-color: #475569 transparent;
        }

        .dark .gradebook-scroll::-webkit-scrollbar-thumb {
            background: #475569;
        }

        .dark .gradebook-scroll::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /*
        |--------------------------------------------------------------------------
        | На мобильных делаем scrollbar немного заметнее
        |--------------------------------------------------------------------------
        */

        @media (max-width: 640px) {
            .gradebook-scroll::-webkit-scrollbar {
                height: 12px;
            }
        }
    </style>


    <!--
    |--------------------------------------------------------------------------
    | Основной контейнер
    |--------------------------------------------------------------------------
    |
    | min-w-0 + overflow-x-hidden не дают широкой таблице растянуть всю страницу.
    | Скролл будет только внутри блока журнала.
    |
    -->
    <div class="w-full min-w-0 max-w-full">
        <!-- ================================================================
             HEADER
        ================================================================= -->

        <div class="flex items-center gap-4 mb-8">

            <div class="w-16 h-16 shrink-0 rounded-2xl
                        bg-amber-600
                        border-b-4 border-amber-800
                        flex items-center justify-center
                        text-white text-3xl font-black
                        shadow-lg shadow-amber-900/20">

                <svg class="w-8 h-8"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 01-6 2.292m0-14.25v14.25">
                    </path>

                </svg>

            </div>

            <div class="min-w-0">

                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white">
                    Журнал преподавателя
                </h1>

                <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 font-bold mt-1">
                    Сводная таблица успеваемости ваших групп
                </p>

            </div>

        </div>


        <!-- ================================================================
             1. ВЫБОР ГРУППЫ
        ================================================================= -->

        <div class="mb-6">

            <p class="text-xs font-black uppercase tracking-widest
                      text-slate-500 dark:text-slate-400 mb-3">
                1. Выберите группу
            </p>

            <div class="flex flex-wrap items-center gap-3">

                @foreach($groups as $group)

                    <a href="{{ route('teacher.gradebook', ['group_id' => $group->id]) }}"
                       class="px-4 sm:px-5 py-2.5
                              rounded-xl
                              font-black text-xs sm:text-sm
                              uppercase tracking-wider
                              transition-all duration-200
                              active:scale-95
                              {{ $selectedGroupId == $group->id
                                  ? 'bg-amber-500 text-amber-950 shadow-lg shadow-amber-500/30 border-2 border-amber-400'
                                  : 'bg-slate-100 dark:bg-slate-800/50 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800 border-2 border-transparent'
                              }}">

                        {{ $group->name }}

                    </a>

                @endforeach

            </div>

        </div>


        <!-- ================================================================
             2. ВЫБОР ДИСЦИПЛИНЫ
        ================================================================= -->

        @if($selectedGroupId && $disciplines->isNotEmpty())

            <div class="mb-8
                        p-4
                        rounded-2xl
                        bg-slate-50 dark:bg-slate-900/50
                        border-2
                        border-slate-100 dark:border-slate-800">

                <p class="text-xs font-black uppercase tracking-widest
                          text-slate-500 dark:text-slate-400 mb-3">
                    2. Выберите дисциплину
                </p>

                <div class="flex flex-wrap items-center gap-3">

                    @foreach($disciplines as $discipline)

                        <a href="{{ route('teacher.gradebook', [
                            'group_id' => $selectedGroupId,
                            'discipline_id' => $discipline->id
                        ]) }}"
                           class="px-4 sm:px-5 py-2.5
                                  rounded-xl
                                  font-black text-xs sm:text-sm
                                  uppercase tracking-wider
                                  transition-all duration-200
                                  active:scale-95
                                  {{ $selectedDisciplineId == $discipline->id
                                      ? 'bg-cyan-500 text-cyan-950 shadow-lg shadow-cyan-500/30 border-2 border-cyan-400'
                                      : 'bg-white dark:bg-slate-800 text-slate-500 border-2 border-slate-200 dark:border-slate-700 hover:border-cyan-500/50 hover:text-cyan-500'
                                  }}">

                            {{ $discipline->name }}

                        </a>

                    @endforeach

                </div>

            </div>

        @elseif($selectedGroupId && $disciplines->isEmpty())

            <div class="mb-8
                        p-4
                        rounded-2xl
                        bg-rose-50 dark:bg-rose-500/10
                        border-2
                        border-rose-200 dark:border-rose-500/20
                        text-rose-600 dark:text-rose-400
                        text-sm font-bold
                        flex items-center gap-2">

                <svg class="w-5 h-5 shrink-0"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2.5"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16.77c-.77 1.333.192 3 1.732 3z">
                    </path>

                </svg>

                <span>
                    К этой группе пока не привязана ни одна дисциплина.
                    (Настройте это в Админке)
                </span>

            </div>

        @endif


        <!-- ================================================================
             EMPTY STATES
        ================================================================= -->

        @if(!$selectedGroupId)

            <div class="py-16
                        px-4
                        text-center
                        bg-white dark:bg-slate-900
                        rounded-3xl
                        border-2 border-dashed
                        border-slate-300 dark:border-slate-700">

                <svg class="mx-auto h-12 w-12 text-slate-400 mb-3"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5">
                    </path>

                </svg>

                <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                    Выберите группу
                </h3>

                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Сначала выберите группу, а затем дисциплину.
                </p>

            </div>


        @elseif($selectedGroupId && !$selectedDisciplineId && $disciplines->isNotEmpty())

            <div class="py-16
                        px-4
                        text-center
                        bg-white dark:bg-slate-900
                        rounded-3xl
                        border-2 border-dashed
                        border-slate-300 dark:border-slate-700">

                <svg class="mx-auto h-12 w-12 text-slate-400 mb-3"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 01-6 2.292m0-14.25v14.25">
                    </path>

                </svg>

                <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                    Выберите дисциплину
                </h3>

                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Нажмите на предмет выше, чтобы загрузить матрицу оценок.
                </p>

            </div>


        @elseif($selectedGroupId &&
                $selectedDisciplineId &&
                ($students->isEmpty() || $tasks->isEmpty()))

            <div class="py-12
                        px-4
                        text-center
                        bg-white dark:bg-slate-900
                        rounded-3xl
                        border-2
                        border-slate-200 dark:border-slate-800">

                <h3 class="text-base font-bold text-slate-800 dark:text-white">
                    Недостаточно данных
                </h3>

                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Либо в группе нет студентов, либо вы еще не создали
                    практических заданий по этому предмету.
                </p>

            </div>


        @elseif($selectedGroupId && $selectedDisciplineId)


            <!-- ============================================================
                 GRADEBOOK
            ============================================================= -->

            <div class="w-full min-w-0
                        bg-white dark:bg-slate-900
                        rounded-3xl
                        border-2
                        border-slate-200 dark:border-slate-800
                        border-b-4
                        shadow-xl shadow-slate-900/5
                        relative">


                <!-- ========================================================
                     MOBILE SCROLL HINT
                ========================================================= -->

                <div class="sm:hidden
                            flex items-center justify-between
                            gap-3
                            px-4 py-3
                            border-b
                            border-slate-200 dark:border-slate-800
                            text-xs
                            font-bold
                            text-slate-400">

                    <span>
                        Журнал
                    </span>

                    <span class="whitespace-nowrap">
                        ← свайпните таблицу →
                    </span>

                </div>


                <!-- ========================================================
                     TABLE SCROLL CONTAINER
                ========================================================= -->

                <div class="w-full min-w-0
                            overflow-x-auto
                            overflow-y-visible
                            rounded-3xl
                            gradebook-scroll">

                    <!--
                    ----------------------------------------------------------
                    ВАЖНО:

                    w-max:
                        таблица может стать шире контейнера.

                    min-w-full:
                        если заданий мало — таблица всё равно занимает
                        всю ширину контейнера.

                    Поэтому:
                        desktop -> нормальная таблица на всю ширину
                        mobile  -> появляется горизонтальный scroll
                    ----------------------------------------------------------
                    -->

                    <table class="w-max min-w-full
                                  text-left
                                  border-collapse">


                        <!-- ==================================================
                             TABLE HEADER
                        ================================================== -->

                        <thead>

                        <tr>


                            <!-- =================================================
                                 STUDENT HEADER
                            ================================================== -->

                            <th class="sticky left-0 z-40
                                       w-[190px]
                                       min-w-[190px]
                                       sm:w-[240px]
                                       sm:min-w-[240px]
                                       bg-slate-50 dark:bg-slate-800
                                       border-b-2
                                       border-slate-200 dark:border-slate-700
                                       px-3 sm:px-6
                                       py-4 sm:py-5
                                       shadow-[4px_0_10px_-5px_rgba(0,0,0,0.18)]">

                                <span class="text-xs font-black
                                             uppercase
                                             tracking-widest
                                             text-slate-500 dark:text-slate-400">

                                    Студент

                                </span>

                            </th>


                            <!-- =================================================
                                 TASK HEADERS
                            ================================================== -->

                            @foreach($tasks as $task)

                                <th class="w-[180px]
                                           min-w-[180px]
                                           max-w-[180px]
                                           px-4
                                           py-5
                                           border-b-2
                                           border-slate-200 dark:border-slate-700
                                           bg-slate-50 dark:bg-slate-800/50
                                           border-l
                                           border-slate-100 dark:border-slate-800/50
                                           align-top">

                                    <p class="text-xs
                                              font-black
                                              text-slate-400
                                              mb-1
                                              uppercase
                                              tracking-wider
                                              whitespace-nowrap">

                                        {{ $task->deadline_at
                                            ? 'До ' . $task->deadline_at->format('d.m')
                                            : 'Без срока'
                                        }}

                                    </p>

                                    <p class="text-sm
                                              font-bold
                                              text-slate-800 dark:text-white
                                              line-clamp-2"
                                       title="{{ $task->title }}">

                                        {{ $task->title }}

                                    </p>

                                </th>

                            @endforeach


                            <!-- =================================================
                                 AVERAGE HEADER
                            ================================================== -->

                            <th class="sticky right-0 z-40
                                       w-[105px]
                                       min-w-[105px]
                                       sm:w-[125px]
                                       sm:min-w-[125px]
                                       bg-violet-50 dark:bg-violet-900/20
                                       border-b-2
                                       border-violet-200 dark:border-violet-800/50
                                       border-l-2
                                       border-slate-200 dark:border-slate-700
                                       px-3 sm:px-6
                                       py-4 sm:py-5
                                       shadow-[-4px_0_10px_-5px_rgba(0,0,0,0.18)]">

                                <span class="text-xs
                                             font-black
                                             uppercase
                                             tracking-widest
                                             text-violet-600 dark:text-violet-400">

                                    Ср. балл

                                </span>

                            </th>

                        </tr>

                        </thead>


                        <!-- ====================================================
                             TABLE BODY
                        ===================================================== -->

                        <tbody class="divide-y-2 divide-slate-100 dark:divide-slate-800/50">


                        @foreach($students as $student)

                            @php
                                $totalScore = 0;
                                $gradedTasksCount = 0;
                            @endphp


                            <tr class="hover:bg-slate-50/50
                                       dark:hover:bg-slate-800/20
                                       group">


                                <!-- =================================================
                                     STUDENT
                                ================================================== -->

                                <td class="sticky left-0 z-30
                                           w-[190px]
                                           min-w-[190px]
                                           sm:w-[240px]
                                           sm:min-w-[240px]
                                           bg-white dark:bg-slate-900
                                           group-hover:bg-slate-50
                                           dark:group-hover:bg-slate-800
                                           px-3 sm:px-6
                                           py-3 sm:py-4
                                           font-bold
                                           text-slate-800 dark:text-white
                                           shadow-[4px_0_10px_-5px_rgba(0,0,0,0.18)]
                                           transition-colors">


                                    <div class="flex items-center gap-2 sm:gap-3">


                                        <!-- Avatar -->

                                        <div class="w-7 h-7
                                                    sm:w-8 sm:h-8
                                                    shrink-0
                                                    rounded-lg
                                                    bg-slate-100 dark:bg-slate-800
                                                    flex items-center justify-center
                                                    text-[10px] sm:text-xs
                                                    font-black
                                                    text-slate-500">

                                            {{ mb_substr($student->surname, 0, 1) }}{{ mb_substr($student->name, 0, 1) }}

                                        </div>


                                        <!-- Name -->

                                        <span class="whitespace-nowrap
                                                     text-sm sm:text-base">

                                            {{ $student->surname }}
                                            {{ $student->name }}

                                        </span>

                                    </div>

                                </td>


                                <!-- =================================================
                                     GRADES
                                ================================================== -->

                                @foreach($tasks as $task)

                                    @php
                                        $submission = $matrix[$student->id][$task->id] ?? null;

                                        $isOverdue = $task->deadline_at &&
                                                     $task->deadline_at->isPast();


                                        if ($submission && is_numeric($submission->grade)) {

                                            $totalScore += $submission->grade;
                                            $gradedTasksCount++;

                                        } elseif (
                                            $isOverdue &&
                                            (!$submission ||
                                             $submission->status === SubmissionStatusEnum::Rejected)
                                        ) {

                                            $totalScore += 2;
                                            $gradedTasksCount++;

                                        }
                                    @endphp


                                    <td class="w-[180px]
                                               min-w-[180px]
                                               max-w-[180px]
                                               border-l
                                               border-slate-100 dark:border-slate-800/50
                                               p-2
                                               text-center
                                               transition-colors">


                                        @if($submission)

                                            @php
                                                $editUrl = route(
                                                    'filament.admin.resources.submissions.edit',
                                                    $submission->id
                                                );
                                            @endphp


                                            <a href="{{ $editUrl }}"
                                               target="_blank"
                                               class="flex
                                                      items-center
                                                      justify-center
                                                      w-full
                                                      min-h-[52px]
                                                      rounded-xl
                                                      p-3
                                                      hover:bg-slate-100
                                                      dark:hover:bg-slate-800
                                                      transition-colors">


                                                @if($submission->status === SubmissionStatusEnum::Pending)

                                                    <span class="inline-flex
                                                                 items-center
                                                                 gap-1.5
                                                                 px-3
                                                                 py-1
                                                                 rounded-lg
                                                                 bg-amber-100
                                                                 dark:bg-amber-500/20
                                                                 text-amber-700
                                                                 dark:text-amber-400
                                                                 text-xs
                                                                 font-bold">

                                                        <span class="w-1.5 h-1.5
                                                                     rounded-full
                                                                     bg-amber-500
                                                                     animate-pulse">
                                                        </span>

                                                        Проверить

                                                    </span>


                                                @elseif($submission->status === SubmissionStatusEnum::Rejected)

                                                    <span class="inline-flex
                                                                 items-center
                                                                 gap-1.5
                                                                 px-3
                                                                 py-1
                                                                 rounded-lg
                                                                 bg-red-100
                                                                 dark:bg-red-500/20
                                                                 text-red-700
                                                                 dark:text-red-400
                                                                 text-xs
                                                                 font-bold">

                                                        Доработка

                                                    </span>


                                                @elseif($submission->grade)

                                                    <span class="text-lg
                                                                 font-black
                                                                 text-emerald-600
                                                                 dark:text-emerald-400">

                                                        {{ $submission->grade }}

                                                    </span>


                                                @else

                                                    <span class="text-sm
                                                                 font-black
                                                                 text-emerald-600
                                                                 dark:text-emerald-400">

                                                        Зачтено

                                                    </span>

                                                @endif

                                            </a>


                                        @else


                                            <div class="p-3 min-h-[52px]
                                                        flex items-center
                                                        justify-center">


                                                @if($isOverdue)

                                                    <!--
                                                    Пропущенное задание =
                                                    автоматическая двойка
                                                    -->

                                                    <span class="text-sm
                                                                 font-black
                                                                 text-rose-500"
                                                          title="Пропущено (Автоматическая двойка)">

                                                        2

                                                    </span>

                                                @else

                                                    <span class="text-slate-300
                                                                 dark:text-slate-600
                                                                 font-bold">

                                                        —

                                                    </span>

                                                @endif

                                            </div>

                                        @endif

                                    </td>

                                @endforeach


                                <!-- =================================================
                                     AVERAGE
                                ================================================== -->

                                @php

                                    $avg = $gradedTasksCount > 0
                                        ? round($totalScore / $gradedTasksCount, 2)
                                        : '—';


                                    $avgColor = 'text-violet-600 dark:text-violet-400';


                                    if ($avg !== '—') {

                                        if ($avg < 3) {

                                            $avgColor = 'text-rose-500';

                                        } elseif ($avg >= 4.5) {

                                            $avgColor = 'text-emerald-500';

                                        }

                                    }

                                @endphp


                                <td class="sticky right-0 z-30
                                           w-[105px]
                                           min-w-[105px]
                                           sm:w-[125px]
                                           sm:min-w-[125px]
                                           bg-violet-50
                                           dark:bg-violet-900/10
                                           border-l-2
                                           border-slate-200
                                           dark:border-slate-700
                                           p-3 sm:p-4
                                           text-center
                                           shadow-[-4px_0_10px_-5px_rgba(0,0,0,0.18)]">


                                    <span class="text-base sm:text-lg
                                                 font-black
                                                 {{ $avgColor }}">

                                        {{ $avg }}

                                    </span>

                                </td>


                            </tr>

                        @endforeach


                        </tbody>

                    </table>

                </div>

            </div>

        @endif

    </div>

@endsection

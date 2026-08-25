@extends('layouts.main')

@section('title', 'Добро пожаловать - ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full flex flex-col items-center text-center py-6 lg:py-10">

        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-2xl bg-emerald-600 border border-emerald-500 text-white text-sm font-bold uppercase tracking-wide mb-6 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-600/20 transition-all duration-300 cursor-default">
            <span class="flex h-2 w-2 rounded-full bg-white animate-pulse"></span>
            Учебная Платформа для студентов
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight mb-6 text-white">
            Все
            <span class="text-violet-400 inline-block hover:scale-110 hover:-rotate-2 transition-transform duration-300 cursor-default">учебные материалы</span> <br class="hidden md:block"/>
            в одном месте
        </h1>

        <p class="text-base sm:text-lg font-medium text-white max-w-2xl mb-10 opacity-90">
            Изучай теорию, смотри мануалы и сдавай практические через платформу.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto px-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-600/30 active:border-b-0 active:translate-y-1 transition-all duration-200 text-center">
                    Перейти к учебным материалам
                </a>
            @else
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-600/30 active:border-b-0 active:translate-y-1 transition-all duration-200 text-center">
                    Регистрация
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-200 font-black uppercase tracking-widest rounded-2xl border-2 border-slate-700 border-b-4 border-b-slate-600 hover:-translate-y-1 hover:shadow-xl active:border-b-0 active:translate-y-1 transition-all duration-200 text-center">
                    Войти
                </a>
            @endauth
        </div>
    </div>

    <section class="py-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            <div class="lg:col-span-3 p-6 sm:p-10 bg-slate-800/80 border border-slate-700 hover:border-slate-500 rounded-3xl flex flex-col justify-center hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 cursor-default">
                <h3 class="text-2xl sm:text-3xl font-black mb-4 text-white">Теория</h3>
                <p class="text-white/80 font-medium text-base sm:text-lg leading-relaxed max-w-md">
                    Методички, лекции и требования к практическим работам собраны в одном месте. Никаких потерянных файлов в мессенджерах.
                </p>
            </div>

            <div class="lg:col-span-2 p-6 sm:p-10 bg-emerald-600 border border-emerald-500 hover:border-emerald-400 rounded-3xl flex flex-col justify-center text-white shadow-xl shadow-emerald-900/20 hover:shadow-emerald-500/30 hover:-translate-y-2 transition-all duration-300 cursor-default">
                <h3 class="text-2xl sm:text-3xl font-black mb-4">Практические</h3>
                <p class="text-emerald-50 font-medium text-base sm:text-lg leading-relaxed">
                    Сдавай практические работы легко — прикрепляй ссылки на GitHub, скидывай файлы напрямую в систему.
                </p>
            </div>

            <div class="group lg:col-span-5 p-6 sm:p-10 bg-violet-950/60 border border-violet-800/50 hover:border-violet-600/50 rounded-3xl flex flex-col lg:flex-row items-center justify-between gap-10 overflow-hidden hover:-translate-y-2 hover:shadow-2xl hover:shadow-violet-900/40 transition-all duration-500 cursor-default">
                <div class="flex-1 w-full text-left">
                    <h3 class="text-2xl sm:text-3xl font-black mb-4 text-white">Обратная связь</h3>
                    <p class="text-white/80 font-medium text-base sm:text-lg leading-relaxed max-w-2xl">
                        Отслеживай статус работы. Преподаватель оставляет комментарии прямо к твоему решению.
                    </p>
                </div>

                <div class="shrink-0 flex flex-col gap-4 w-full lg:w-auto relative">

                    <div class="inline-flex items-center gap-3 px-5 py-3.5 bg-amber-500/10 text-amber-400 font-bold rounded-2xl border border-amber-500/30 w-fit transform group-hover:-translate-y-3 group-hover:-translate-x-2 transition-transform duration-500 ease-out">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Отправлено на проверку
                    </div>

                    <div class="inline-flex items-center gap-3 px-5 py-3.5 bg-emerald-500/10 text-emerald-400 font-bold rounded-2xl border border-emerald-500/30 w-fit lg:ml-8 transform group-hover:-translate-y-6 group-hover:translate-x-2 transition-transform duration-700 ease-out delay-75">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Зачтено
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

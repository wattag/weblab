@php use App\Enums\UserRoleEnum; @endphp

<aside class="hidden md:flex flex-col w-64 shrink-0 h-full border-r-2 border-slate-800/60 bg-slate-950 p-4 justify-between z-10">
    <div>
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-2 py-4 mb-6 hover:opacity-80 transition">
            <div class="w-12 h-12 flex items-center justify-center text-white font-black text-xl">
                <img src="{{ asset('logo.ico') }}" alt="Логотип">
            </div>
            <span class="text-2xl font-extrabold text-white tracking-tight">{{ config('app.name', 'WebLab') }}</span>
        </a>

        <nav class="flex flex-col gap-2">
            @auth
                @if(auth()->user()->role === UserRoleEnum::Student)
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold uppercase tracking-wide text-sm transition {{ request()->routeIs('dashboard') ? 'bg-violet-500/10 text-violet-400 border-2 border-violet-500/20' : 'text-slate-500 border-2 border-transparent hover:bg-slate-900' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Мой профиль
                    </a>
                @endif

                <a href="{{ route('theory') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold uppercase tracking-wide text-sm transition {{ request()->routeIs('theory') ? 'bg-indigo-500/10 text-indigo-400 border-2 border-indigo-500/20' : 'text-slate-500 border-2 border-transparent hover:bg-slate-900' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Теория
                </a>

                <a href="{{ route('practice') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold uppercase tracking-wide text-sm transition {{ request()->routeIs('practice') ? 'bg-emerald-500/10 text-emerald-400 border-2 border-emerald-500/20' : 'text-slate-500 border-2 border-transparent hover:bg-slate-900' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    Практика
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold uppercase tracking-wide text-sm transition {{ request()->routeIs('profile.edit') ? 'bg-slate-500/10 text-slate-300 border-2 border-slate-500/20' : 'text-slate-500 border-2 border-transparent hover:bg-slate-900' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Настройки
                </a>

                @if(auth()->user()->role === UserRoleEnum::Teacher)
                    <a href="{{ url('/admin') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-slate-900 text-slate-500 font-bold uppercase tracking-wide text-sm transition mt-4 border-2 border-transparent">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Панель преподавателя
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl hover:bg-slate-900 text-slate-500 font-bold uppercase tracking-wide text-sm transition border-2 border-transparent">
                    Войти
                </a>
            @endauth
        </nav>
    </div>

    @auth
        <div>
            <form method="POST" action="{{ route('logout') }}" class="m-0 w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl border-2 border-slate-800 text-slate-500 hover:bg-slate-900 font-bold uppercase tracking-wide text-sm transition active:translate-y-1">
                    Выйти
                </button>
            </form>
        </div>
    @endauth
</aside>

<nav class="md:hidden fixed bottom-0 left-0 w-full bg-slate-950 border-t-2 border-slate-800 flex justify-around items-center h-20 z-50 shadow-2xl">
    <a href="{{ route('dashboard') }}" class="p-3 transition {{ request()->routeIs('dashboard') ? 'text-violet-500' : 'text-slate-400 hover:text-violet-400' }}">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
    </a>
    <a href="{{ route('theory') }}" class="p-3 transition {{ request()->routeIs('theory') ? 'text-indigo-500' : 'text-slate-400 hover:text-indigo-400' }}">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
    </a>
    <a href="{{ route('practice') }}" class="p-3 transition {{ request()->routeIs('practice') ? 'text-emerald-500' : 'text-slate-400 hover:text-emerald-400' }}">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
    </a>
    @auth
        <a href="{{ route('profile.edit') }}" class="p-3 transition {{ request()->routeIs('profile.edit') ? 'text-slate-200' : 'text-slate-400 hover:text-slate-200' }}">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </a>
    @endauth
</nav>

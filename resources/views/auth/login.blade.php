@section('title', 'Авторизация - ' . config('app.name', 'WebLab'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">С возвращением!</h2>
        <p class="mt-2 text-sm font-bold text-slate-500 dark:text-slate-400">Войдите, чтобы продолжить работу</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email адрес" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="student@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5">
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Пароль" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-slate-400 hover:text-violet-500 transition-colors" href="{{ route('password.request') }}">
                        Забыли пароль?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-violet-600 shadow-sm focus:ring-violet-500 dark:focus:ring-violet-500 dark:focus:ring-offset-slate-800" name="remember">
                <span class="ms-2 text-sm font-bold text-slate-500 dark:text-slate-400">Запомнить меня</span>
            </label>
        </div>

        <div class="mt-8 flex flex-col gap-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-900/20 active:border-b-0 active:translate-y-1 transition-all duration-200 text-center">
                Войти
            </button>

            <p class="text-center text-sm font-bold text-slate-500 dark:text-slate-400">
                Нет аккаунта?
                <a href="{{ route('register') }}" class="text-violet-500 hover:text-violet-400 transition-colors">
                    Зарегистрироваться
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

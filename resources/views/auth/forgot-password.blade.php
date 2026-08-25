@section('title', 'Восстановление пароля - ' . config('app.name', 'WebLab'))

<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-violet-500/10 border-2 border-violet-500/20 text-violet-500 mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path></svg>
        </div>
        <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Забыли пароль?</h2>
        <p class="mt-2 text-sm font-bold text-slate-500 dark:text-slate-400">
            Без проблем. Введите ваш email, и мы отправим ссылку для сброса пароля.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border-2 border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-sm font-bold flex items-center gap-3">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email адрес" />
            <x-text-input id="email" class="block mt-1 w-full focus:border-violet-500 focus:ring-violet-500 dark:focus:border-violet-500 dark:focus:ring-violet-500" type="email" name="email" :value="old('email')" required autofocus placeholder="student@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8 flex flex-col gap-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-900/20 active:border-b-0 active:translate-y-1 transition-all duration-200 text-center">
                Отправить ссылку
            </button>

            <p class="text-center text-sm font-bold text-slate-500 dark:text-slate-400">
                Вспомнили пароль?
                <a href="{{ route('login') }}" class="text-violet-500 hover:text-violet-400 transition-colors">
                    Вернуться ко входу
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

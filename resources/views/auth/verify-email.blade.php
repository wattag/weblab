@section('title', 'Подтверждение почты | ' . config('app.name', 'WebLab'))

<x-guest-layout>
    <!-- Шапка с иконкой письма -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-cyan-500/10 border-2 border-cyan-500/20 text-cyan-500 mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
        </div>
        <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Проверьте почту</h2>

        <p class="mt-4 text-sm font-bold text-slate-500 dark:text-slate-400 leading-relaxed">
            Спасибо за регистрацию! Прежде чем начать работу с заданиями, пожалуйста, подтвердите свой email, перейдя по ссылке, которую мы только что отправили вам.
        </p>
        <p class="mt-2 text-sm font-bold text-slate-500 dark:text-slate-400 leading-relaxed">
            Если вы не получили письмо, нажмите на кнопку ниже, и мы отправим его снова.
        </p>
    </div>

    <!-- Уведомление о повторной отправке -->
    @if (session('status') === 'verification-link-sent')
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border-2 border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-sm font-bold flex items-center gap-3">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Новая ссылка для подтверждения была успешно отправлена!
        </div>
    @endif

    <div class="mt-8 flex flex-col gap-4">
        <!-- Кнопка "Отправить еще раз" -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-900/20 active:border-b-0 active:translate-y-1 transition-all duration-200 text-center">
                Отправить письмо еще раз
            </button>
        </form>

        <!-- Кнопка логаута (серая) -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 bg-slate-800 hover:bg-slate-700 text-slate-200 font-black uppercase tracking-widest rounded-2xl border-2 border-slate-700 border-b-4 border-b-slate-600 active:border-b-0 active:translate-y-1 transition text-center">
                Выйти из аккаунта
            </button>
        </form>
    </div>
</x-guest-layout>

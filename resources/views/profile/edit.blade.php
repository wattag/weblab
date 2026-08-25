@extends('layouts.main')

@section('title', 'Настройки профиля - ' . config('app.name', 'WebLab'))

@section('content')
    <div class="w-full">

        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-violet-500 mb-8 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Назад в профиль
        </a>

        <h1 class="text-3xl sm:text-4xl font-black text-slate-800 dark:text-white mb-8">Настройки</h1>

        <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 p-6 sm:p-10 mb-8">
            <header class="mb-6">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white">Личные данные</h2>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Обновите информацию о себе и email адрес.
                </p>
            </header>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
                @csrf
                @method('patch')

                <div>
                    <label for="surname" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Фамилия</label>
                    <input id="surname" name="surname" type="text" value="{{ old('surname', $user->surname) }}" required autofocus
                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                    @error('surname') <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Имя</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                    @error('name') <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="patronymic" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Отчество</label>
                    <input id="patronymic" name="patronymic" type="text" value="{{ old('patronymic', $user->patronymic) }}" required
                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                    @error('patronymic') <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email адрес</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                    @error('email') <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="inline-flex justify-center py-3.5 px-8 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 active:border-b-0 active:translate-y-1 transition-all text-center shadow-lg shadow-violet-900/20">
                        Сохранить
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-emerald-500 flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            Успешно
                        </p>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-800 border-b-4 p-6 sm:p-10 mb-8">
            <header class="mb-6">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white">Изменить пароль</h2>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">
                    Убедитесь, что ваш аккаунт использует длинный и случайный пароль для безопасности.
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Текущий пароль</label>
                    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                    @error('current_password', 'updatePassword') <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="update_password_password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Новый пароль</label>
                    <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                    @error('password', 'updatePassword') <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Подтвердите пароль</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                           class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 focus:ring-violet-500 rounded-xl shadow-sm transition-colors py-3">
                    @error('password_confirmation', 'updatePassword') <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="inline-flex justify-center py-3.5 px-8 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 active:border-b-0 active:translate-y-1 transition-all text-center shadow-lg shadow-violet-900/20">
                        Обновить
                    </button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-emerald-500 flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            Пароль изменен
                        </p>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-red-50 dark:bg-red-950/20 rounded-3xl border-2 border-red-200 dark:border-red-900/50 border-b-4 p-6 sm:p-10" x-data="{ confirmingUserDeletion: false }">
            <header class="mb-6">
                <h2 class="text-2xl font-black text-red-600 dark:text-red-500">Удалить аккаунт</h2>
                <p class="mt-1 text-sm font-medium text-slate-500 dark:text-slate-400 max-w-xl">
                    После удаления вашего аккаунта все его ресурсы и данные будут удалены навсегда. Пожалуйста, загрузите любую информацию, которую хотите сохранить.
                </p>
            </header>

            <button x-on:click="confirmingUserDeletion = true" class="inline-flex justify-center py-3.5 px-8 bg-red-600 hover:bg-red-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-red-500 border-b-4 border-b-red-700 hover:border-b-red-600 active:border-b-0 active:translate-y-1 transition-all text-center">
                Удалить аккаунт
            </button>

            <div x-show="confirmingUserDeletion" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-slate-900/80 backdrop-blur-sm">
                <div x-show="confirmingUserDeletion"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-90"
                     class="bg-white dark:bg-slate-900 rounded-3xl border-2 border-slate-200 dark:border-slate-700 shadow-2xl p-6 sm:p-10 max-w-xl w-full"
                     @click.away="confirmingUserDeletion = false">

                    <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-2">Вы уверены?</h2>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-6">
                        Пожалуйста, введите ваш пароль, чтобы подтвердить удаление аккаунта. Это действие нельзя отменить.
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <input type="password" name="password" placeholder="Ваш пароль" required autofocus
                               class="block w-full bg-white dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm transition-colors py-3 mb-6">
                        @error('password', 'userDeletion') <p class="mb-4 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror

                        <div class="flex flex-col-reverse sm:flex-row gap-4 sm:justify-end">
                            <button type="button" x-on:click="confirmingUserDeletion = false" class="inline-flex justify-center py-3.5 px-6 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-white font-black uppercase tracking-widest rounded-2xl border-2 border-slate-300 dark:border-slate-700 border-b-4 border-b-slate-400 dark:border-b-slate-900 active:border-b-0 active:translate-y-1 transition-all text-center">
                                Отмена
                            </button>
                            <button type="submit" class="inline-flex justify-center py-3.5 px-6 bg-red-600 hover:bg-red-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-red-500 border-b-4 border-b-red-700 hover:border-b-red-600 active:border-b-0 active:translate-y-1 transition-all text-center">
                                Да, удалить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

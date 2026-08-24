@section('title', 'Регистрация - ' . config('app.name', 'WebLab'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Регистрация</h2>
        <p class="mt-2 text-sm font-bold text-slate-500 dark:text-slate-400">Создайте аккаунт для доступа к заданиям</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="surname" value="Фамилия" />
            <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autofocus autocomplete="surname" placeholder="Иванов" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="name" value="Имя" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Иван" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="patronymic" value="Отчество" />
            <x-text-input id="patronymic" class="block mt-1 w-full" type="text" name="patronymic" :value="old('patronymic')" required autocomplete="patronymic" placeholder="Иванович" />
            <x-input-error :messages="$errors->get('patronymic')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email адрес" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="student@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="group_id" value="Учебная группа" />
            <select id="group_id" name="group_id" class="block mt-1 w-full bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-violet-500 dark:focus:ring-violet-500 rounded-xl shadow-sm transition-colors cursor-pointer" required>
                <option value="" disabled selected>Выберите вашу группу</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" @selected(old('group_id') == $group->id)>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('group_id')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Пароль" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Подтвердите пароль" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8 flex flex-col gap-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 bg-violet-600 hover:bg-violet-500 text-white font-black uppercase tracking-widest rounded-2xl border-2 border-violet-500 border-b-4 border-b-violet-700 hover:border-b-violet-600 hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-900/20 active:border-b-0 active:translate-y-1 transition-all duration-200 text-center">
                Зарегистрироваться
            </button>

            <p class="text-center text-sm font-bold text-slate-500 dark:text-slate-400">
                Уже есть аккаунт?
                <a href="{{ route('login') }}" class="text-violet-500 hover:text-violet-400 transition-colors">
                    Войти в систему
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

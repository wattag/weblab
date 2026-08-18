<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-600 text-white">
            <x-filament::icon
                icon="heroicon-m-academic-cap"
            />
        </div>

        <div class="fi-account-widget-main">
            <h2 class="fi-account-widget-heading">
                Учебная платформа
            </h2>

            <p class="fi-account-widget-user-name">
                {{ config('app.name', 'WebLab') }}
            </p>
        </div>

        <div class="fi-account-widget-logout-form">
            <x-filament::button
                color="gray"
                icon="heroicon-m-globe-alt"
                labeled-from="sm"
                tag="a"
                href="{{ url('/') }}"
                target="_blank"
            >
                Перейти на сайт
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

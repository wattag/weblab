<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Подтверждение регистрации - ' . config('app.name'))
                ->greeting('Привет, ' . $notifiable->name . '!')
                ->line('Добро пожаловать на учебную платформу. Чтобы получить доступ к заданиям, необходимо подтвердить свой email.')
                ->action('Подтвердить Email', $url)
                ->line('Если ты не регистрировался на платформе, просто проигнорируй это письмо.')
                ->salutation('С уважением, преподаватель.');
        });    }
}

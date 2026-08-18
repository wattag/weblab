<?php

namespace App\Filament\Widgets;

use App\Enums\SubmissionStatusEnum;
use App\Enums\UserRoleEnum;
use App\Filament\Resources\Groups\Pages\ListGroups;
use App\Filament\Resources\Submissions\Pages\ListSubmissions;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\Group;
use App\Models\Submission;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendingSubmissionsWidget extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';
    protected function getStats(): array
    {
        $pendingCount = Submission::where('status', SubmissionStatusEnum::Pending)->count();
        $acceptedCount = Submission::where('status', SubmissionStatusEnum::Accepted)->count();

        return [
            Stat::make('Преподавателей', User::where('role', UserRoleEnum::Teacher)->count())
                ->description('Зарегистрировано на курсе')
                ->icon('heroicon-m-academic-cap')
                ->url(route(ListUsers::getRouteName(), [
                    'filters' => [
                        'role' => [
                            'value' => UserRoleEnum::Teacher->value,
                        ],
                    ],
                ])),

            Stat::make('Студентов', User::where('role', UserRoleEnum::Student)->count())
                ->description('Зарегистрировано на курсе')
                ->icon('heroicon-m-users')
                ->url(route(ListUsers::getRouteName(), [
                    'filters' => [
                        'role' => [
                            'value' => UserRoleEnum::Student->value,
                        ],
                    ],
                ])),

            Stat::make('Групп', Group::all()->count())
                ->description('Зарегистрировано на курсе')
                ->icon('heroicon-m-rectangle-group')
                ->url(route(ListGroups::getRouteName())),

            Stat::make('Ожидают проверки', $pendingCount)
                ->description($pendingCount > 0 ? 'Есть работы для проверки' : 'Все работы проверены')
                ->color($pendingCount > 0 ? 'warning' : 'success')
                ->icon('heroicon-m-clock')
                ->url(urldecode(route(ListSubmissions::getRouteName(), [
                    'filters' => [
                        'status' => [
                            'value' => SubmissionStatusEnum::Pending->value,
                        ],
                    ],
                ]))),

            Stat::make('Приняты', $acceptedCount)
                ->description('Успешно сданные практические работы')
                ->color('success')
                ->icon('heroicon-m-check-circle')
                ->url(urldecode(route(ListSubmissions::getRouteName(), [
                    'filters' => [
                        'status' => [
                            'value' => SubmissionStatusEnum::Accepted->value,
                        ],
                    ],
                ]))),

            Stat::make('Отменены', Submission::where('status', SubmissionStatusEnum::Rejected)->count())
                ->description('Работы, отправленные на доработку')
                ->color('danger')
                ->icon('heroicon-m-x-circle')
                ->url(urldecode(route(ListSubmissions::getRouteName(), [
                    'filters' => [
                        'status' => [
                            'value' => SubmissionStatusEnum::Rejected->value,
                        ],
                    ],
                ]))),
        ];
    }
}

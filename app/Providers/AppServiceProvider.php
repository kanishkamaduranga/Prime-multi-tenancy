<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LanguageService;
use Filament\Facades\Filament;
use App\View\Components\LanguageSwitcherDropdown;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LanguageService::class, function () {
            return new LanguageService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
           /* Filament::registerUserMenuItems([

                'language_switcher' => [
                    'component' => LanguageSwitcherDropdown::class,
                    'sort' => 100, // Adjust the position as needed
                ],
            ]);*/
        });
    }
}

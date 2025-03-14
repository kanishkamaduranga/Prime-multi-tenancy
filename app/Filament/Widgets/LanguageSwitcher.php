<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Widget
{
    protected static string $view = 'filament.widgets.language-switcher';


    public function getLocales(): array
    {
        return config('app.available_locales', ['en', 'es', 'fr']);
    }

    public function switch($locale)
    {
        if (!in_array($locale, ['si', 'ta', 'en'])) {
            abort(400);
        }

        Session::put('locale', $locale);
        return redirect()->back();
    }
}

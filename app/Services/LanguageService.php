<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LanguageService
{
    /**
     * Get the current locale.
     *
     * @return string
     */
    public function getLocale()
    {
        $locale = 'si';
        if (Session::has('locale')){
            $locale = Session::get('locale');
        } else {
            $locale = config('app.locale');
        }

        return $locale;
    }

    /**
     * Set the application locale.
     *
     * @param string $locale
     * @return bool
     */
    public function setLocale($locale)
    {
        // Validate the locale
        if (!in_array($locale, ['si', 'ta', 'en'])) {
            return false;
        }

        Session::put('locale', $locale);

        return true;
    }
}

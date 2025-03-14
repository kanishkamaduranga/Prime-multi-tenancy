<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Services\LanguageService;



class LanguageController extends Controller
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function switch($locale)
    {
        if (!in_array($locale, ['si', 'ta', 'en'])) {
            abort(400);
        }

        \Log::info("Controler vaue : " .$locale);
        Session::put('locale', $locale);

        // Set the locale using the LanguageService
        if ($this->languageService->setLocale($locale)) {
            return redirect()->back();
        }

        // Handle invalid locale
        abort(400, 'Invalid locale');
    }
}

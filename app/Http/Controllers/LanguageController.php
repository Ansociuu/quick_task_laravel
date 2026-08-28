<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Thay đổi ngôn ngữ ứng dụng
     */
    public function switchLanguage(string $locale): RedirectResponse
    {
        if (in_array($locale, ['en', 'vi'])) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}

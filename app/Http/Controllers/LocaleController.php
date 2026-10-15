<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        $available = config('app.available_locales', ['es', 'en']);

        abort_unless(in_array($locale, $available, true), 404);

        session(['locale' => $locale]);

        $previous = url()->previous();
        $fallback = route('home');

        if (! $previous || $previous === $request->fullUrl()) {
            return redirect()->to($fallback);
        }

        return redirect()->to($previous);
    }
}

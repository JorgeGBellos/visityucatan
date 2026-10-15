<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanEventRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PlanEventController extends Controller
{
    public function create(): View
    {
        return view('pages.plan');
    }

    public function store(StorePlanEventRequest $request): RedirectResponse
    {
        $request->validated();

        return redirect()
            ->route('pages.plan.confirmation')
            ->with('plan_submitted', true);
    }

    public function confirmation(): View|RedirectResponse
    {
        if (! session()->pull('plan_submitted')) {
            return redirect()->route('pages.plan');
        }

        return view('pages.plan-confirmation');
    }
}

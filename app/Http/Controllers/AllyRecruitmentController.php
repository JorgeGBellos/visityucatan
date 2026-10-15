<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAllyRecruitmentRequest;
use App\Models\AllyApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AllyRecruitmentController extends Controller
{
    public function create(): View
    {
        return view('pages.allies-recruit');
    }

    public function store(StoreAllyRecruitmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $photoPaths = [];

        foreach ($request->file('photos', []) as $photo) {
            $photoPaths[] = $photo->store('ally-applications', 'public');
        }

        AllyApplication::query()->create([
            'business_name' => $data['business_name'],
            'business_type' => $data['business_type'],
            'description' => $data['description'],
            'phone' => $data['phone'],
            'website' => $data['website'],
            'photos' => $photoPaths,
            'status' => AllyApplication::STATUS_PENDING,
        ]);

        return redirect()
            ->route('pages.allies.recruit.confirmation')
            ->with('ally_recruit_submitted', true);
    }

    public function confirmation(): View|RedirectResponse
    {
        if (! session()->pull('ally_recruit_submitted')) {
            return redirect()->route('pages.allies.recruit');
        }

        return view('pages.allies-recruit-confirmation');
    }
}

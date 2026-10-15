<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlanEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('full_name') && (! $this->filled('first_name') || ! $this->filled('last_name'))) {
            $parts = preg_split('/\s+/', trim((string) $this->input('full_name')), 2) ?: [];
            $first = $parts[0] ?? '';
            $last = $parts[1] ?? $first;

            $this->merge([
                'first_name' => $this->filled('first_name') ? $this->input('first_name') : $first,
                'last_name' => $this->filled('last_name') ? $this->input('last_name') : $last,
            ]);
        }

        $this->merge([
            'attendees' => $this->filled('attendees') ? $this->input('attendees') : null,
            'estimated_date' => $this->filled('estimated_date') ? $this->input('estimated_date') : null,
            'has_venue' => $this->filled('has_venue') ? $this->input('has_venue') : null,
            'event_type' => $this->filled('event_type') ? $this->input('event_type') : null,
            'origin' => $this->filled('origin') ? $this->input('origin') : null,
            'message' => $this->filled('message') ? $this->input('message') : null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $helpKeys = array_keys(__('site.plan.help'));

        return [
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'company' => ['nullable', 'string', 'max:160'],
            'position' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'country' => ['nullable', 'string', 'max:80'],
            'event_name' => ['nullable', 'string', 'max:160'],
            'event_type' => ['nullable', 'string', 'max:120'],
            'estimated_date' => ['nullable', 'date'],
            'attendees' => ['nullable', 'integer', 'min:1', 'max:999999'],
            'origin' => ['nullable', 'string', 'max:160'],
            'has_venue' => ['nullable', Rule::in(['yes', 'no'])],
            'message' => ['nullable', 'string', 'max:2000'],
            'full_name' => ['nullable', 'string', 'max:160'],
            'help' => ['nullable', 'array'],
            'help.*' => ['string', Rule::in($helpKeys)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => __('site.plan.validation.first_name'),
            'last_name.required' => __('site.plan.validation.last_name'),
            'email.required' => __('site.plan.validation.email'),
            'email.email' => __('site.plan.validation.email_invalid'),
            'estimated_date.date' => __('site.plan.validation.estimated_date'),
            'attendees.integer' => __('site.plan.validation.attendees'),
            'attendees.min' => __('site.plan.validation.attendees'),
            'has_venue.in' => __('site.plan.validation.has_venue'),
        ];
    }
}

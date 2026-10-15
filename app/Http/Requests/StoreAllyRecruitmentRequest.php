<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAllyRecruitmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:160'],
            'business_type' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:600'],
            'phone' => ['required', 'string', 'max:60'],
            'website' => ['required', 'string', 'max:255'],
            'photos' => ['required', 'array', 'min:1', 'max:5'],
            'photos.*' => ['required', 'image', 'max:10240'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'business_name.required' => __('site.ally_recruit.validation.business_name'),
            'business_type.required' => __('site.ally_recruit.validation.business_type'),
            'description.required' => __('site.ally_recruit.validation.description'),
            'description.max' => __('site.ally_recruit.validation.description_max'),
            'phone.required' => __('site.ally_recruit.validation.phone'),
            'website.required' => __('site.ally_recruit.validation.website'),
            'photos.required' => __('site.ally_recruit.validation.photos'),
            'photos.min' => __('site.ally_recruit.validation.photos'),
            'photos.max' => __('site.ally_recruit.validation.photos_max'),
            'photos.*.image' => __('site.ally_recruit.validation.photos_type'),
            'photos.*.max' => __('site.ally_recruit.validation.photos_size'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'business_name' => __('site.ally_recruit.fields.business_name'),
            'business_type' => __('site.ally_recruit.fields.business_type'),
            'description' => __('site.ally_recruit.fields.description'),
            'phone' => __('site.ally_recruit.fields.phone'),
            'website' => __('site.ally_recruit.fields.website'),
            'photos' => __('site.ally_recruit.fields.photos'),
        ];
    }
}

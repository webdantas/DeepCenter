<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'required', Rule::exists('users', 'id')->where('tenant_id', auth()->user()->tenant_id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'timezone' => ['required', 'string', 'timezone'],
            'language' => ['required', 'string', Rule::in(['en', 'pt-BR', 'es'])],
            'theme' => ['required', 'string', Rule::in(['light', 'dark'])],
            'notifications_enabled' => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.exists' => 'The selected user does not belong to your tenant.',
            'avatar.max' => 'The avatar must not be larger than 2MB.',
            'timezone.timezone' => 'The timezone must be a valid timezone.',
            'language.in' => 'The language must be one of: English, Portuguese (Brazil), or Spanish.',
            'theme.in' => 'The theme must be either light or dark.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'user',
            'bio' => 'biography',
            'avatar' => 'profile picture',
            'phone' => 'phone number',
            'postal_code' => 'ZIP/postal code',
            'notifications_enabled' => 'notifications',
        ];
    }
}

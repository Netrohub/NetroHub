<?php

namespace App\Http\Requests\Auth;

use App\Services\TurnstileService;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];

        // Only require Turnstile if it's configured
        if (config('services.turnstile.secret_key')) {
            $rules['cf-turnstile-response'] = ['required', 'string'];
        }

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Only validate Turnstile if it's configured
            if (config('services.turnstile.secret_key')) {
                $turnstileService = app(TurnstileService::class);
                $token = $this->input('cf-turnstile-response');
                
                // Log the token for debugging
                \Log::info('Turnstile validation attempt', [
                    'token_present' => !empty($token),
                    'token_length' => $token ? strlen($token) : 0,
                    'ip' => $this->ip()
                ]);
                
                if (!$turnstileService->verifyToken($token, $this->ip())) {
                    $validator->errors()->add('cf-turnstile-response', 'Human verification failed. Please try again.');
                }
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => __('عنوان البريد الإلكتروني مطلوب.'),
            'email.email' => __('يرجى إدخال عنوان بريد إلكتروني صحيح.'),
            'password.required' => __('كلمة المرور مطلوبة.'),
            'remember.boolean' => __('تذكرني يجب أن يكون صحيح أو خطأ.'),
            'cf-turnstile-response.required' => __('يرجى إكمال التحقق الأمني.'),
        ];
    }
}

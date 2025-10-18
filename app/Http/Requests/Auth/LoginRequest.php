<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

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
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'cf-turnstile-response' => ['required'],
            'remember' => ['nullable', 'boolean'],
        ];
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
            if (! $this->verifyTurnstile()) {
                $validator->errors()->add('cf-turnstile-response', 'Cloudflare verification failed. Please try again.');
            }
        });
    }

    /**
     * Verify Turnstile token with Cloudflare
     */
    protected function verifyTurnstile(): bool
    {
        $token = $this->input('cf-turnstile-response');
        $secretKey = env('TURNSTILE_SECRET_KEY');

        if (! $secretKey) {
            // If Turnstile is not configured, allow the request
            return true;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $this->ip(),
            ]);

            $result = $response->json();

            return $result['success'] ?? false;
        } catch (\Exception $e) {
            // Log the error and allow the request (fail open for better UX)
            \Log::error('Turnstile verification error: '.$e->getMessage());

            return true;
        }
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
            'cf-turnstile-response.required' => __('يرجى إكمال التحقق الأمني.'),
        ];
    }
}

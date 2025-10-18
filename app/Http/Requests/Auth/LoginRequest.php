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
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'cf-turnstile-response' => ['required', 'string'],
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
            $turnstileService = app(TurnstileService::class);
            $token = $this->input('cf-turnstile-response');
            
            if (!$turnstileService->verify($token, $this->ip())) {
                $validator->errors()->add('cf-turnstile-response', 'Human verification failed. Please try again.');
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

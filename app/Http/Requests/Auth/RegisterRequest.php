<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'min:3', 'max:24', 'regex:/^[A-Za-z0-9_]+$/', 'unique:users,username'],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
            'country_code' => ['required', 'string', 'in:+971,+966,+965,+973,+974,+968,+1,+44,+91,+86,+81,+49,+33,+61,+20,+55,+52,+34'],
            'phone' => [
                'required', 
                'string', 
                'max:15', 
                'regex:/^[0-9]+$/',
                function ($attribute, $value, $fail) {
                    $fullPhone = $this->input('country_code') . $value;
                    if (User::where('phone_number', $fullPhone)->exists()) {
                        $fail('This phone number is already registered.');
                    }
                }
            ],
            'password' => [
                'required', 
                'string', 
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'terms' => ['required', 'accepted'],
            // Only require Turnstile if it's configured
            ...(config('services.turnstile.secret_key') ? ['cf-turnstile-response' => ['required']] : []),
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
            // Only validate Turnstile if it's configured
            if (config('services.turnstile.secret_key')) {
                $turnstileService = app(\App\Services\TurnstileService::class);
                $token = $this->input('cf-turnstile-response');
                
                if (!$turnstileService->verify($token, $this->ip())) {
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
            'name.required' => __('الاسم مطلوب.'),
            'name.min' => __('يجب أن يكون الاسم حرفين على الأقل.'),
            'name.max' => __('لا يمكن أن يتجاوز الاسم 60 حرفاً.'),
            'username.required' => __('اسم المستخدم مطلوب.'),
            'username.min' => __('يجب أن يكون اسم المستخدم 3 أحرف على الأقل.'),
            'username.max' => __('لا يمكن أن يتجاوز اسم المستخدم 24 حرفاً.'),
            'username.regex' => __('يمكن أن يحتوي اسم المستخدم على أحرف وأرقام وشرطات سفلية فقط.'),
            'username.unique' => __('اسم المستخدم هذا مستخدم مسبقاً.'),
            'email.required' => __('عنوان البريد الإلكتروني مطلوب.'),
            'email.email' => __('يرجى إدخال عنوان بريد إلكتروني صحيح.'),
            'email.unique' => __('هذا البريد الإلكتروني مسجل مسبقاً.'),
            'password.required' => __('كلمة المرور مطلوبة.'),
            'password.confirmed' => __('تأكيد كلمة المرور غير متطابق.'),
            'phone.required' => __('رقم الهاتف مطلوب.'),
            'phone.max' => __('لا يمكن أن يتجاوز رقم الهاتف 15 رقم.'),
            'phone.regex' => __('يجب أن يحتوي رقم الهاتف على أرقام فقط.'),
            'country_code.required' => __('رمز الدولة مطلوب.'),
            'country_code.in' => __('رمز الدولة المحدد غير صحيح.'),
            'terms.required' => __('يجب عليك قبول الشروط والأحكام.'),
            'terms.accepted' => __('يجب عليك قبول الشروط والأحكام.'),
            'cf-turnstile-response.required' => __('يرجى إكمال التحقق الأمني.'),
        ];
    }
}

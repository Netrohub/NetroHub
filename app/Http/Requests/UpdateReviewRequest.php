<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by policy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'between:1,5'],
            'title' => ['nullable', 'string'],
            'body' => ['required', 'string'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize body - strip URLs, emails, phone numbers
        if ($this->has('body')) {
            $this->merge([
                'body' => $this->sanitizeBody($this->input('body')),
            ]);
        }
    }

    /**
     * Sanitize review body by removing contact info and links
     */
    protected function sanitizeBody(string $text): string
    {
        // Remove URLs (http://, https://, www.)
        $text = preg_replace('#(https?://[^\s]+)#i', '[link removed]', $text);
        $text = preg_replace('#(www\.[^\s]+)#i', '[link removed]', $text);

        // Remove email addresses
        $text = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', '[email removed]', $text);

        // Remove phone numbers (various formats)
        $text = preg_replace('/(\+?\d{1,3}[-.\s]?)?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}/', '[phone removed]', $text);
        $text = preg_replace('/\d{3}[-.\s]?\d{3}[-.\s]?\d{4}/', '[phone removed]', $text);

        // Remove excessive whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Please select a rating.',
            'rating.between' => 'Rating must be between 1 and 5 stars.',
            'body.required' => 'Please write your review.',
        ];
    }
}

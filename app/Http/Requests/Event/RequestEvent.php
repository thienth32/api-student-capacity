<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class RequestEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'max:5000',
            'note' => 'max:5000',
            'register_link' => 'nullable|url',
            'interview_count' => 'numeric|min:0',
            'jobs_opening_count' => 'numeric|min:0',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after_or_equal:start_at|after_or_equal:now',
            'thumbnail' => $this->isMethod('post') 
                ? 'required|mimes:jpeg,png,jpg|max:10000'
                : 'nullable|mimes:jpeg,png,jpg|max:10000',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only allow updates if user is admin, owner of project, or assigned marketing
        return $this->user()->can('update', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'project_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'owner_id' => [
                'nullable',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->whereHas('role', function ($q) {
                        $q->where('name', 'owner');
                    });
                })
            ],
            'marketing_id' => [
                'nullable',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->whereHas('role', function ($q) {
                        $q->where('name', 'marketing');
                    });
                })
            ]
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
            'owner_id.exists' => 'The selected owner must be a user with owner role.',
            'marketing_id.exists' => 'The selected marketing must be a user with marketing role.',
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
            'project_name' => 'project name',
        ];
    }
}

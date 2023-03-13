<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'description'    => 'string',
            'title'          => 'string|unique:tasks,title',
            'visible_to_all' => 'bool',
            'status'         => 'int',
            'complete_until' => 'string',
            'completed_in'   => 'string',
            'completed_by'   => 'int',
            'assigned_to'    => 'string',
            'user_type'      => 'int',
            'completed_by'   => 'int'
        ];
    }
}

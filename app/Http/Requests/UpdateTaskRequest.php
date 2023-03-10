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
            'title'          => 'string',
            'visible_to_all' => 'bool',
            'status_id'      => 'int',
            'complete_until' => 'date',
            'assigned_to'    => 'int',
            'completed_by'   => 'int'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'description'    => 'string|required',
            'title'          => 'string|required|unique:tasks,title',
            'visible_to_all' => 'bool|required',
            'status_id'      => 'int',
            'complete_until' => 'string',
            'assigned_to'    => 'string',
            'completed_by'   => 'int'
        ];
    }
}

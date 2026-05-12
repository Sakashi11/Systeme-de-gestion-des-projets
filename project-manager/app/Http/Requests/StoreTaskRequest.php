<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority'    => 'in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'      => 'Le titre de la tâche est obligatoire',
            'assigned_to.exists'  => 'L\'utilisateur assigné n\'existe pas',
        ];
    }
}
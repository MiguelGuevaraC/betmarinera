<?php

namespace App\Http\Requests\ContestRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Requests\UpdateRequest;
class UpdateContestRequest extends UpdateRequest
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
            'name' => 'required|string|max:255',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
        ];
    }
    
    public function messages()
    {
        return [
            // Mensajes para 'name'
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.regex' => 'El nombre no debe contener solo números.',
    
            // Mensajes para 'start_date'
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.string' => 'La fecha de inicio debe ser una cadena válida.',
    
            // Mensajes para 'end_date'
            'end_date.required' => 'La fecha de fin es obligatoria.',
            'end_date.string' => 'La fecha de fin debe ser una cadena válida.',
        ];
    }
    

}

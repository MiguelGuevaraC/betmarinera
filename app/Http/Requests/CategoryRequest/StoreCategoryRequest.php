<?php

namespace App\Http\Requests\CategoryRequest;

use App\Http\Requests\StoreRequest;

class StoreCategoryRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cambia esto si necesitas autorización específica
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'contest_id' => 'required|string',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'contest_id.required' => 'El concurso es obligatorio.',
            'contest_id.nullable' => 'El campo del concurso puede estar vacío.',
            'contest_id.string' => 'El ID del concurso debe ser una cadena de texto.',
        ];
    }
    
    
    

}

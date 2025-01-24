<?php

namespace App\Http\Requests\ContestantRequest;

use App\Http\Requests\StoreRequest;

class StoreContestantRequest extends StoreRequest
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
        'names'       => 'required|string',
        'description' => 'nullable|string',
        'status'      => 'nullable|string',
        'category_id' => 'required|integer|exists:categories,id,deleted_at,NULL', // Validación de categoría existente y no eliminada
        'contest_id' => 'required|integer|exists:contests,id,deleted_at,NULL', // Validación de categoría existente y no eliminada
    ];
}

public function messages()
{
    return [
        'names.required'       => 'El nombre del concursante es obligatorio.',
        'names.string'         => 'El nombre del concursante debe ser una cadena de texto.',
        'description.string'   => 'La descripción debe ser una cadena de texto.',
     
        'status.string'        => 'El estado debe ser una cadena de texto.',
        'category_id.required' => 'La categoría es obligatoria.',
        'category_id.integer'  => 'El ID de la categoría debe ser un número entero.',
        'category_id.exists'   => 'La categoría seleccionada no existe.',

        'contest_id.exists'   => 'El concurso seleccionado no existe.',
    ];
}

    
    

}

<?php

namespace App\Http\Requests\BetRequest;

use App\Http\Requests\StoreRequest;

class StoreUpdateBetRequest extends StoreRequest
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
        
        'category_id' => 'required|integer|exists:categories,id,deleted_at,NULL', // Validación de categoría existente y no eliminada
        'contestant_id' => 'required|integer|exists:contestants,id,deleted_at,NULL', // Validación de categoría existente y no eliminada
    ];
}

public function messages()
    {
        return [
          

            'category_id.required' => 'El ID de categoría es obligatorio.',
            'category_id.integer' => 'El ID de categoría debe ser un número entero.',
            'category_id.exists' => 'La categoría seleccionada no existe o ha sido eliminada.',

            'contestant_id.required' => 'El ID de concursante es obligatorio.',
            'contestant_id.integer' => 'El ID de concursante debe ser un número entero.',
            'contestant_id.exists' => 'El concursante seleccionado no existe o ha sido eliminado.',
        ];
    }

    
    

}

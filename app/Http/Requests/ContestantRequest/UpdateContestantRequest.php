<?php

namespace App\Http\Requests\ContestantRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Requests\UpdateRequest;
class UpdateContestantRequest extends UpdateRequest
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
            'names'       => 'required|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id,deleted_at,NULL', // Validación de categoría existente y no eliminada
        ];
    }
    
    public function messages()
    {
        return [
            'names.required'       => 'El nombre de la categoría es obligatorio.',
            'names.string'         => 'El nombre de la categoría debe ser una cadena de texto.',
            'description.string'   => 'La descripción debe ser una cadena de texto.',
  
            'status.string'        => 'El estado debe ser una cadena de texto.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.integer'  => 'El ID de la categoría debe ser un número entero.',
            'category_id.exists'   => 'La categoría seleccionada no existe o ha sido eliminada.',
        ];
    }
    

}

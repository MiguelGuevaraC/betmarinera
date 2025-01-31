<?php
namespace App\Http\Requests\CategoryRequest;

use App\Http\Requests\IndexRequest;
use App\Models\Contest;

class IndexCategoryContestActiveRequest extends IndexRequest
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
    public function rules(): array
    {
        return [
            'name'       => 'nullable|string',
            'contest_id' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $contest = Contest::where('id', $value)
                    // ->where('status', 'Activo')
                    ->first();

                    if (! $contest) {
                        $fail("El $attribute no es válido o el concurso no está activo.");
                    }
                },
            ],
        ];
    }
    public function messages()
    {
        return [
            'name.required'       => 'El nombre es obligatorio.',
            'contest_id.required' => 'El concurso es obligatorio.',
            'contest_id.string'   => 'El ID del concurso debe ser una cadena válida.',
            'contest_id.exists'   => 'El concurso seleccionado no existe o no está activo.',
        ];
    }

}

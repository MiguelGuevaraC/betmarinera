<?php
namespace App\Http\Requests\ContestantRequest;

use App\Http\Requests\IndexRequest;

class IndexContestantRequest extends IndexRequest
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

            'names'       => 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|string',
            'category_id' => 'nullable|string',
           
        ];
    }
}

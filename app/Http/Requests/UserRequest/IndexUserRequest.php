<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\IndexRequest;

class IndexUserRequest extends IndexRequest
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

            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'route' => 'nullable|string',
            'status' => 'nullable|string',

            'company$business_name' => 'nullable|string',

        ];
    }
}

<?php
namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ContestantResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Contestant",
     *     title="Contestant",
     *     description="Contestant model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="name", type="string", example="juliio y andrea" ),
     *     @OA\Property( property="description", type="string", example="van en parejas" ),
     *     @OA\Property( property="status", type="string", example="Activo" ),
     *     @OA\Property( property="category_id", type="integer", example="1" ),
     *     @OA\Property(property="category", ref="#/components/schemas/Category"),
     *

     * )
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,

            'names'       => $this->names ?? null,
            'description' => $this->description ?? null,

            'status'      => $this->status ?? null,
            'statusbet'      => $this->consultarstatus($this->category_id,Auth::user()->id,$this->id) ?? null,
'bet'      => $this->getbet($this->category_id,Auth::user()->id,$this->id) ?? null,

            'category_id' => $this->category_id ?? null,
            'category'    => $this->category ? new CategoryResource($this->category) : null,

        ];
    }
}

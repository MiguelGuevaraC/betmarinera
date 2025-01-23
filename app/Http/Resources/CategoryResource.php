<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Category",
     *     title="Category",
     *     description="Category model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="name", type="integer", example="name" ),
     *     @OA\Property( property="description", type="integer", example="description" ),
     *     @OA\Property( property="contest_id", type="integer", example="1" ),
     *     @OA\Property(property="user", ref="#/components/schemas/Contest"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? null,
            'description' => $this->description ?? null,
            'contest_id'   => $this->contest_id ?? null,
            'contest'     => $this->contest ? new ContestResource($this->contest) :  null,
        ];
    }
}

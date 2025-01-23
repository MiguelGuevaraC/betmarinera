<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category_winnerResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Category_winner",
     *     title="Category_winner",
     *     description="Category_winner model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="category_id", type="integer", example="1" ),
     *     @OA\Property(property="category", ref="#/components/schemas/Category"),
     * 
     *     @OA\Property( property="contest_id", type="integer", example="1" ),
     *     @OA\Property(property="contest", ref="#/components/schemas/Contest"),
     * 
     * 
     *     @OA\Property( property="contestant_id", type="integer", example="1" ),
     *     @OA\Property(property="contestant", ref="#/components/schemas/Contestant"),
     * )
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,

            'cateogry_id'   => $this->cateogry_id ?? null,
            'cateogry'     => $this->cateogry ? new CategoryResource($this->category) :  null,

            'contest_id'   => $this->contest_id ?? null,
            'contest'     => $this->contest ? new ContestResource($this->contest) :  null,

            'contestant_id'   => $this->contestant_id ?? null,
            'contestant'     => $this->contestant ? new ContestResource($this->contestant) :  null,
        ];
    }
}

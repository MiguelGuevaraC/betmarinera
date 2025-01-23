<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BetResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Bet",
     *     title="Bet",
     *     description="Bet model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="user_id", type="integer", example="1" ),
     *     @OA\Property(property="user", ref="#/components/schemas/User"),
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
            'name'       => $this->name ?? null,
            'description' => $this->description ?? null,

            'user_id'   => $this->user_id ?? null,
            'user'     => $this->user ? new UserResource($this->user) :  null,

            'contest_id'   => $this->contest_id ?? null,
            'contest'     => $this->contest ? new ContestResource($this->contest) :  null,

            'contestant_id'   => $this->contestant_id ?? null,
            'contestant'     => $this->contestant ? new ContestResource($this->contestant) :  null,
        ];
    }
}

<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contestant_winsResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Contestant_wins",
     *     title="Contestant_wins",
     *     description="Contestant_wins model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="user_id", type="integer", example="1" ),
     *     @OA\Property(property="user", ref="#/components/schemas/User"),
     *
     *     @OA\Property( property="contest_id", type="integer", example="1" ),
     *     @OA\Property(property="contest", ref="#/components/schemas/Contest"),

     * )
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,

            'user_id'    => $this->user_id ?? null,
            'user'       => $this->user ? new UserResource($this->user) : null,

            'contest_id' => $this->contest_id ?? null,
            'contest'    => $this->contest ? new ContestResource($this->contest) : null,

        ];
    }
}

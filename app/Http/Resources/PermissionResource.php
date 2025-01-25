<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Permission",
     *     title="Permission",
     *     description="Permission model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="name", type="string", example="users" ),
     *     @OA\Property( property="type", type="string", example="Tipo-01" ),
     *     @OA\Property( property="status", type="string", example="Activo" ),
     * )
     */
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name ?? null,
            'route'   => $this->route ?? null,
            'icon'   => $this->icon ?? null,
            'type'   => $this->type ?? null,
            'status' => $this->status ?? null,
        ];
    }
}

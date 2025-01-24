<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="User",
     *     title="User",
     *     description="User model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="email", type="string", example="miguel@gmail.com" ),
     *     @OA\Property(property="rol_id",type="integer",description="Rol Id", example="1"),
     *     @OA\Property(property="rol", ref="#/components/schemas/Rol")
     * )
     */
    public function toArray($request)
    {
        // Generar los valores como strings para pasarlos al botón
        $userId = (string) $this->id ?? 'null';
        $firstName = (string) $this->first_name ?? '';
        $lastName = (string) $this->last_name ?? '';
        $email = (string) $this->email ?? '';
    
        // Crear el botón con los parámetros como cadenas de texto
        $actionButtons = '  
            <button class="btn btn-sm btn-warning" onclick="editUser('
            . "'$userId', '$firstName', '$lastName', '$email'" . ')" 
            data-toggle="tooltip" title="Editar Usuario">
                <i class="fa fa-edit"></i>
            </button>
            
            <button class="btn btn-sm btn-danger" onclick="deleteuser(' . $this->id . ')" data-toggle="tooltip" title="Eliminar Concurso">
            <i class="fa fa-trash"></i>
        </button>
        ';

         
    
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name ?? null,
            'last_name'  => $this->last_name ?? null,
            'email'      => $this->email ?? null,
            'count-win'  => 0 ?? null,
            'rol_id'     => $this->rol_id ?? null,
            'rol'        => $this->rol ? new RolResource($this->rol) : null,
            'action'     => $actionButtons,
        ];
    }
    
}

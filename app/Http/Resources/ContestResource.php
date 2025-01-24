<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContestResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Contest",
     *     title="Contest",
     *     description="Contest model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="name", type="string", example="concurso01" ),
     *     @OA\Property(property="start_date", type="string", format="date-time", example="2024-01-01T00:00:00Z"),
     *     @OA\Property(property="end_date", type="string", format="date-time", example="2024-01-01T00:00:00Z"),
     *  @OA\Property( property="status", type="string", example="concurso01" ),
     * )
     */
    public function toArray($request)
    {
        // Definir el botón de acción solo si tiene 1 categoría y 2 participantes
        $actionButtons = '
        <button class="btn btn-sm btn-primary" onclick="showCategories(' . $this->id . ')" data-toggle="tooltip" title="Agregar Categorías">
            <i class="fa fa-tags"></i>
        </button>

        <button class="btn btn-sm btn-warning" onclick="editContest(' . $this->id . ', \'' . $this->name . '\', \'' . $this->start_date . '\', \'' . $this->end_date . '\')" data-toggle="tooltip" title="Editar Concurso">
            <i class="fa fa-edit"></i>
        </button>
';

        if ($this->categories()->count() > 0) {
            $actionButtons .= '<button class="btn btn-sm btn-success" onclick="showContestants(' . $this->id . ')" data-toggle="tooltip" title="Agregar Participantes">
    <i class="fa fa-users"></i>
</button>';
        }
        if ($this->categories()->count() == 0) {
            $actionButtons .= '<button class="btn btn-sm btn-danger" onclick="deleteContest(' . $this->id . ')" data-toggle="tooltip" title="Eliminar Concurso">
        <i class="fa fa-trash"></i>
    </button>';
        }

        if ($this->categories()->count() > 0 && $this->contestants()->count() > 1 && $this->status != 'Activo') {
            $actionButtons .= '

                <button class="btn btn-sm btn-warning" onclick="activateContest(' . $this->id . ')" data-toggle="tooltip" title="Activar">
                    <i class="fa fa-check"></i>
                </button>';
        }

        return [
            'id'                => $this->id,
            'name'              => $this->name ?? null,
            'start_date'        => $this->start_date ?? null,
            'end_date'          => $this->end_date ?? null,
            'categories_count'  => $this->categories()->count(),  // Cuenta las categorías
            'contestants_count' => $this->contestants()->count(), // Cuenta los concursantes
            'status'            => $this->status ?? null,
            'action'            => $actionButtons, // Solo incluirá los botones si cumple la condición
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
        ];
    }

}

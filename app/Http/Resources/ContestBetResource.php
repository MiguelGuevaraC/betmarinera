<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContestBetResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="ContestBet",
     *     title="ContestBet",
     *     description="ContestBet model",
     *     @OA\Property( property="id", type="integer", example="1" ),
     *     @OA\Property( property="name", type="string", example="concurso01" ),
     *     @OA\Property(property="start_date", type="string", format="date-time", example="2024-01-01T00:00:00Z"),
     *     @OA\Property(property="end_date", type="string", format="date-time", example="2024-01-01T00:00:00Z"),
     *  @OA\Property( property="status", type="string", example="concurso01" ),
     * )
     */
    public function toArray($request)
    {
        $actionButtons = '';
        $actionButtons .= '
                    <button class="btn btn-sm btn-info" onclick="viewBetDetails(' . $this->contest_id . ')" data-toggle="tooltip" title="Visualizar Apuesta">
                        <i class="fa fa-eye"></i>
                    </button>

    ';

    if ($this->contest->user == "Finalizado") {
        $actionButtons .= '<button class="btn btn-sm btn-danger" onclick="downloadWinnersReport(' . $this->contest_id . ', \'' . $this->contest->name . '\')" data-toggle="tooltip" title="Descargar Reporte de Ganadores">
                            <i class="fas fa-file-excel"></i>
                        </button>';
    }

     
            $actionButtons .= '<button class="btn btn-sm btn-danger" onclick="downloadWinnersReportMiApuesta(' . $this->contest_id . ', \'' . $this->contest->name . '\')" data-toggle="tooltip" title="Descargar Reporte de mi Apuesta">
                                <i class="fas fa-file-excel"></i>
                            </button>';
     
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'user'       => $this->user ? new UserResource($this->user) : null,
            'contest_id' => $this->contest_id,
            'contest'    => $this->contest ? new ContestResource($this->contest) : null,
            'action'     => $actionButtons,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
        ];
    }

}

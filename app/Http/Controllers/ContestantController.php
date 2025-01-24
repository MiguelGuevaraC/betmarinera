<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContestantRequest\IndexContestantRequest;
use App\Http\Requests\ContestantRequest\StoreContestantRequest;
use App\Http\Requests\ContestantRequest\UpdateContestantRequest;
use App\Http\Resources\ContestantResource;
use App\Models\Contestant;
use App\Services\ContestantService;
use Illuminate\Http\Request;

class ContestantController extends Controller
{
    protected $contestantService;

    public function __construct(ContestantService $contestantService)
    {
        $this->contestantService = $contestantService;
    }
  
/**
 * @OA\Get(
 *     path="/betmarinera/public/api/contestant",
 *     summary="Obtener información con filtros y ordenamiento",
 *     tags={"Contestant"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="name", in="query", description="Filtrar por nombre", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="description", in="query", description="Filtrar por descripción", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="route", in="query", description="Filtrar por ruta", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="status", in="query", description="Filtrar por estado", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="company$business_name", in="query", description="Filtrar por nombre de empresa", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="company_id", in="query", description="Filtrar por id Empresa", required=false, @OA\Schema(type="string")),
 *     @OA\Parameter(name="from", in="query", description="Fecha de inicio", required=false, @OA\Schema(type="string", format="date")),
 *     @OA\Parameter(name="to", in="query", description="Fecha de fin", required=false, @OA\Schema(type="string", format="date")),
 *     @OA\Response(response=200, description="Lista de Entornos", @OA\JsonContent(ref="#/components/schemas/Environment")),
 *     @OA\Response(response=422, description="Validación fallida", @OA\JsonContent(@OA\Property(property="error", type="string")))
 * )
 */

    public function list(IndexContestantRequest $request)
    {

        return $this->getFilteredResults(
            Contestant::class,
            $request,
            Contestant::filters,
            Contestant::sorts,
            ContestantResource::class
        );
    }


    public function store(StoreContestantRequest $request)
    {
        $contest = $this->contestantService->createContestant($request->validated());
        return new ContestantResource($contest);
    }
    public function update(UpdateContestantRequest $request, $id)
    {
        $validatedData = $request->validated();

        $contest = $this->contestantService->getContestantById($id);
        if (! $contest) {
            return response()->json([
                'error' => 'Contesta no encontrada',
            ], 404);
        }

        $updatedCompany = $this->contestantService->updateContestant($contest, $validatedData);
        return new ContestantResource($updatedCompany);
    }

    public function destroy($id)
    {
        $contest = Contestant::find($id);

        if (! $contest) {
            return response()->json([
                'message' => 'Concurso no encontrado.',
            ], 404);
        }
        if ($contest->categories()->exists()) {
            return response()->json([
                'message' => 'El concurso tiene categorías asociadas.',
            ], 422);
        }
        if ($contest->contestants()->exists()) {
            return response()->json([
                'message' => 'El concurso tiene concursantes asociados.',
            ], 422);
        }

        $contest->delete();

        return response()->json([
            'message' => 'Concurso eliminado exitosamente.',
        ], 200);
    }
}

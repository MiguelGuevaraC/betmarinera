<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContestRequest\IndexContestRequest;
use App\Http\Requests\ContestRequest\StoreContestRequest;
use App\Http\Requests\ContestRequest\UpdateContestRequest;
use App\Http\Resources\ContestResource;
use App\Models\Contest;

use App\Services\ContestService;
use Illuminate\Http\Request;

class ContestController extends Controller
{

    protected $contestService;

    public function __construct(ContestService $contestService)
    {
        $this->contestService = $contestService;
    }
    public function index(Request $request)
    {
        return view('Contestant-list');
    }
/**
 * @OA\Get(
 *     path="/betmarinera/public/api/Contest",
 *     summary="Obtener información con filtros y ordenamiento",
 *     tags={"Contest"},
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

    public function list(IndexContestRequest $request)
    {

        return $this->getFilteredResults(
            Contest::class,
            $request,
            Contest::filters,
            Contest::sorts,
            ContestResource::class
        );
    }

    public function listcategories(Request $request, $id)
    {
        return $this->contestService->getCategories($id);
    }

    public function store(StoreContestRequest $request)
    {
        $contest = $this->contestService->createContest($request->validated());
        return new ContestResource($contest);
    }
    public function update(UpdateContestRequest $request, $id)
    {
        $validatedData = $request->validated();

        $contest = $this->contestService->getContestById($id);
        if (! $contest) {
            return response()->json([
                'error' => 'Contesta no encontrada',
            ], 404);
        }

        $updatedCompany = $this->contestService->updateContest($contest, $validatedData);
        return new ContestResource($updatedCompany);
    }

    public function destroy($id)
    {
        $contest = Contest::find($id);

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
        if ($contest->Contests()->exists()) {
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

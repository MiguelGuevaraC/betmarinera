<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContestRequest\IndexContestRequest;
use App\Http\Requests\ContestRequest\StoreContestRequest;
use App\Http\Requests\ContestRequest\UpdateContestRequest;
use App\Http\Resources\ContestResource;
use App\Models\Bet;
use App\Models\Contest;
use App\Models\Contest_bet;
use App\Models\User;
use App\Services\ContestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
{

    protected $contestService;

    public function __construct(ContestService $contestService)
    {
        $this->contestService = $contestService;
    }
    public function index(Request $request)
    {
        return view('contestant-list');
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
                'error' => 'Concurso no encontrada',
            ], 404);
        }

        $updatedCompany = $this->contestService->updateContest($contest, $validatedData);
        return new ContestResource($updatedCompany);
    }

    public function updateStatusFinalizado(Request $request, $id)
    {
        $contest = $this->contestService->getContestById($id);
        if (! $contest) {
            return response()->json([
                'error' => 'Concurso no encontrado',
            ], 404);
        }
        if ($contest->status == 'Finalizado') {
            return response()->json([
                'error' => 'Concurso ya está Finalizado',
            ], 422);
        }

        $updatedCompany = $this->contestService->updateContestStatusFinalizado($contest, $request->toArray());
        return new ContestResource($updatedCompany);
    }

    public function updateStatusActivo(Request $request, $id)
    {
        $contest = $this->contestService->getContestById($id);
        if (! $contest) {
            return response()->json([
                'error' => 'Concurso no encontrado',
            ], 404);
        }
        if ($contest->status == 'Activo') {
            return response()->json([
                'error' => 'Concurso ya está Activo',
            ], 422);
        }

        $updatedCompany = $this->contestService->updateContestStatusActivo($contest, $request->toArray());
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

    public function confirmbet(Request $request)
    {
        $contestId = $request->get('contest_id', null);
        if ($contestId == null) {
            return response()->json(['error' => 'Id Concurso es obligatorio'], 422);
        }
        $contest = $this->contestService->getContestById($contestId);
        if (! $contest) {
            return response()->json(['error' => 'Concurso No Encontrado'], 422);
        }
        if ($contest->status != "Activo") {
            return response()->json(['error' => 'Concurso No esta Activo'], 422);
        }

        if ($contest->consultarstatusByUser() == "Apuesta Confirmada") {
            return response()->json(['error' => 'Este concurso ya tiene una apuesta realizada.'], 422);
        }
        $categories = $contest->categories ?? [];
        $userBets   = Contest_bet::where('user_id', Auth::user()->id)
            ->where('contest_id', $contest->id)
            ->with('categories')
            ->get()
            ->pluck('categories.*.id') // Obtener los IDs de las categorías apostadas
            ->flatten()
            ->toArray();

        // Obtener los IDs de todas las categorías del concurso
        $categoryIds = $categories->pluck('id')->toArray();

        // Verificar si el usuario ha apostado en todas las categorías
        if (count(array_diff($categoryIds, $userBets)) > 0) {
            return response()->json(['message' => 'Debes apostar en todas las categorías antes de confirmar.'], 400);
        }

        $contest = $this->contestService->confirmBet($contestId);

        return new ContestResource($contest);
    }

    public function listapostadoresbycontest($id)
    {
        // Buscar el concurso
        $contest = Contest::find($id);
        if (! $contest) {
            return response()->json(['error' => 'Concurso no Encontrado'], 422);
        }

        // Obtener todos los usuarios, incluyendo aquellos que no han realizado apuestas
        $users = User::with(['bets' => function ($query) use ($contest) {
            // Obtener las apuestas solo para el concurso actual
            $query->whereIn('category_id', $contest->categories->pluck('id'));
        }])
            ->whereNull('deleted_at') // Solo usuarios no eliminados
            ->get();

        // Inicializar el arreglo de apostadores con puntajes
        $scores = [];

        // Iterar sobre los usuarios
        foreach ($users as $user) {
            // Inicializar el puntaje del usuario
            $score = 0;

            // Verificar si el usuario tiene apuestas
            foreach ($user->bets as $bet) {
                $category = $bet->category;

                // Verificar si la apuesta es correcta
                if ($bet->contestant_id == $category->contestantwin_id) {
                    $score++;
                }
            }

            // Agregar el apostador al arreglo con el puntaje
            $scores[] = [
                'name_apostador' => $user->first_name . " " . $user->last_name,
                'score'          => $score,
            ];
        }

        // Ordenar los apostadores por puntaje en orden descendente
        usort($scores, function ($a, $b) {
            return $b['score'] - $a['score'];
        });

        // Asignar el campo 'status' a "Ganador" al primero en la lista
        foreach ($scores as $index => $apostador) {
            $scores[$index]['status'] = ($index == 0) ? 'Ganador' : 'No Gano';
        }

        // Respuesta con los apostadores y los puntajes
        return response()->json([
            "data" => $scores,
        ]);
    }

}

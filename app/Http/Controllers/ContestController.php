<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContestRequest\IndexContestRequest;
use App\Http\Requests\ContestRequest\StoreContestRequest;
use App\Http\Requests\ContestRequest\UpdateContestRequest;
use App\Http\Resources\ContestResource;
use App\Models\Bet;
use App\Models\Contest;
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

        $contest = $this->contestService->confirmBet($contestId);

        return new ContestResource($contest);
    }

    public function listapostadoresbycontest($id)
    {
        // Buscar el concurso
        $contest = Contest::find($id);
        if (!$contest) {
            return response()->json(['error' => 'Concurso no Encontrado'], 422);
        }
    
        // Inicializar el arreglo de apostadores
        $apostadores = [];
    
        // Obtener todas las categorías del concurso
        $categories = $contest->categories;
    
        // Obtener todas las apuestas de los usuarios para las categorías del concurso
        $betsQuery = Bet::whereIn('category_id', $categories->pluck('id'))
            ->with('user');
    
        // Filtrar por nombre de usuario si se pasa un parámetro de búsqueda
        if (request()->has('search') && request()->input('search')) {
            $search = request()->input('search');
            $betsQuery->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%");
            });
        }
    
        // Obtener las apuestas con paginación
        $bets = $betsQuery->paginate(25);
    
        // Agrupar las apuestas por usuario
        $userBets = $bets->getCollection()->groupBy('user_id');
    
        // Inicializar un arreglo para almacenar los puntajes de los apostadores
        $scores = [];
    
        // Iterar sobre los usuarios que han apostado
        foreach ($userBets as $userId => $userBetsCollection) {
            // Inicializar el puntaje del usuario
            $score = 0;
    
            // Obtener las apuestas del usuario
            foreach ($userBetsCollection as $bet) {
                $category = $bet->category;
    
                // Verificar si la apuesta es correcta
                if ($bet->contestant_id == $category->contestantwin_id) {
                    $score++;
                }
            }
    
            // Obtener los detalles del usuario (solo una vez)
            $user = $userBetsCollection->first()->user;
    
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
    
        // Respuesta con los apostadores, la paginación, y los links
        return response()->json([
            "data" => $scores,
            "links" => [
                "first" => $bets->url(1),
                "last" => $bets->url($bets->lastPage()),
                "prev" => $bets->previousPageUrl(),
                "next" => $bets->nextPageUrl(),
            ],
            "meta" => [
                "current_page" => $bets->currentPage(),
                "from" => $bets->firstItem(),
                "last_page" => $bets->lastPage(),
                "links" => [
                    [
                        "url" => $bets->previousPageUrl(),
                        "label" => "&laquo; Previous",
                        "active" => !$bets->onFirstPage()
                    ],
                    [
                        "url" => $bets->url($bets->currentPage()),
                        "label" => $bets->currentPage(),
                        "active" => true
                    ],
                    [
                        "url" => $bets->nextPageUrl(),
                        "label" => "Next &raquo;",
                        "active" => $bets->hasMorePages()
                    ]
                ],
                "path" => url()->current(),
                "per_page" => $bets->perPage(),
                "to" => $bets->lastItem(),
                "total" => $bets->total()
            ]
        ]);
    }
    
    

}

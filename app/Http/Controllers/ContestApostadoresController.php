<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContestRequest\IndexContestRequest;
use App\Http\Resources\ContestBetResource;
use App\Http\Resources\ContestResource;
use App\Models\Contest;
use App\Models\Contest_bet;
use App\Services\ContestService;
use Illuminate\Http\Request;

class ContestApostadoresController extends Controller
{
    protected $contestService;

    public function __construct(ContestService $contestService)
    {
        $this->contestService = $contestService;
    }
    public function index(Request $request)
    {
        return view('contestant-list-apostador');
    }

    public function list(IndexContestRequest $request)
    {
        // Obtén los resultados filtrados
        $results = $this->getFilteredResults(
            Contest_bet::class,
            $request,
            Contest_bet::filters,
            Contest_bet::sorts,
            ContestBetResource::class
        );
    
        // Obtén el user_id del usuario logueado
        $userId = auth()->id(); // Asumiendo que estás usando Laravel's autenticación
    
        // Filtra los resultados por user_id antes de agrupar
        $filteredResults = $results->filter(function ($item) use ($userId) {
            return $item->user_id == $userId;
        });
    
        // Filtra los concursos para que solo haya un concurso único por 'contest_id'
        $uniqueContests = $filteredResults->groupBy('contest_id')->map(function ($group) {
            // Toma el primer elemento de cada grupo, ya que todos tienen el mismo contest_id
            return $group->first();
        });
    
        // Convertir la colección de grupos en un array simple
        $uniqueContests = $uniqueContests->values(); // Esto convierte el grupo a un array sin claves
    
        // Mapea los resultados para obtener el formato que necesitas usando el recurso ContestBetResource
        $mappedResults = $uniqueContests->map(function ($item) {
            return new ContestBetResource($item); // Asegúrate de pasar el modelo de concurso real
        });
    
        // Crear la respuesta con los datos, links de paginación y meta
        $response = [
            'data'  => $mappedResults, // Los resultados ahora están en formato de array
            'links' => [
                'first' => url()->current() . '?page=1',
                'last'  => url()->current() . '?page=' . $results->lastPage(),
                'prev'  => $results->previousPageUrl(),
                'next'  => $results->nextPageUrl(),
            ],
            'meta'  => [
                'current_page' => $results->currentPage(),
                'from'         => $results->firstItem(),
                'last_page'    => $results->lastPage(),
                'per_page'     => $results->perPage(),
                'total'        => $results->total(),
            ],
        ];
    
        // Retorna la respuesta estructurada
        return response()->json($response);
    }
    

}

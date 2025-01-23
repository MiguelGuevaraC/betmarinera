<?php

namespace App\Http\Controllers;


use App\Http\Requests\ContestantRequest\IndexContestantRequest;
use App\Http\Resources\ContestantResource;
use App\Http\Resources\ContestResource;
use App\Models\Contest;
use App\Models\Contestant;
use Illuminate\Http\Request;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class ConstantController extends Controller
{
    public function index(Request $request)
    {
        return view('constant');
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
         Contest::class,
         $request,
         Contest::filters,
         Contest::sorts,
         ContestResource::class
     );
 }

}

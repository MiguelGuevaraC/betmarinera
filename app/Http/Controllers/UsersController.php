<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContestantRequest\IndexContestantRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        return view('users');
    }

    /**
     * @OA\Get(
     *     path="/betmarinera/public/api/user",
     *     summary="Obtener información con filtros y ordenamiento",
     *     tags={"User"},
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
        $request->merge(['status' => 'Activo']);
        return $this->getFilteredResults(
            User::class,
            $request,
            User::filters,
            User::sorts,
            UserResource::class
        );
    }

    /**
     * @OA\Get(
     *     path="/betmarinera/public/api/user/{id}",
     *     summary="Obtener detalles de un usuario por ID",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", description="ID del Usuario", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Usuario encontrado", @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response=404, description="Usuario No Encontrado", @OA\JsonContent(type="object", @OA\Property(property="error", type="string", example="Usuario No Encontrado")))
     * )
     */

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (! $user) {
            return response()->json([
                'error' => 'Usuario No Encontrado',
            ], 404);
        }

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user         = User::find($id);
        $user->status = "Inactivo";
        $user->save();
        return response()->json([
            'message' => 'Concurso eliminado exitosamente.',
        ], 200);
    }
}

<?php
namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest\LoginRequest;
use App\Http\Resources\UserResource;
use App\Mail\SendTokenMail;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Get(
     *     path="/bet-marinera/public/api/logout",
     *     tags={"Authentication"},
     *     summary="Logout",
     *     description="Log out user.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated.",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="An error occurred while trying to log out. Please try again later.")
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        return $this->authService->logout();
    }
    /**
     * @OA\Post(
     *     path="/bet-marinera/public/api/login",
     *     summary="Login user",
     *     tags={"Authentication"},
     *     description="Authenticate user and generate access token",
     * security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User credentials",
     *         @OA\JsonContent(
     *             required={"username", "password", "branchOffice_id"},
     *             @OA\Property(property="username", type="string", example="admin"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),

     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User authenticated successfully",
     *         @OA\JsonContent(
     *              @OA\Property(property="token", type="string", description="token del usuario"),
     *             @OA\Property(
     *             property="user",
     *             type="object",
     *             description="User",
     *             ref="#/components/schemas/User"
     *          ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Message Response"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="User not found or password incorrect",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Error message")
     *         )
     *     ),
     *       @OA\Response(
     *         response=401,
     *         description="Unauthenticated.",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Unauthenticated.")
     *         )
     *     ),
     * )
     */

    public function login(LoginRequest $request): JsonResponse
    {

        try {

            $data = $request->only(['email', 'password']);
            // Llama al servicio de autenticación
            $authData = $this->authService->login($request->email, $request->password);

            // Verifica si el usuario es null
            if (! $authData['user']) {
                return response()->json([
                    'error' => $authData['message'],
                ], 422);
            }

            // Retorna la respuesta con el token y el recurso del usuario
            return response()->json([
                'token'   => $authData['token'],
                'user'    => new UserResource($authData['user']),
                'message' => $authData['message'],
            ]);
        } catch (\Exception $e) {
            // Captura cualquier excepción y retorna el mensaje de error
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/bet-marinera/public/api/authenticate",
     *     summary="Get Profile user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     description="Get user",
     *     @OA\Response(
     *         response=200,
     *         description="User authenticated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 description="Bearer token"
     *             ),
     *             @OA\Property(
     *             property="user",
     *             type="object",
     *             description="User",
     *             ref="#/components/schemas/User"
     *              ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Message Response"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="The given data was invalid.")
     *         )
     *     ),
     *        @OA\Response(
     *         response=401,
     *         description="Unauthenticated.",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Unauthenticated.")
     *         )
     *     ),
     * )
     */

    public function authenticate(Request $request)
    {
        // Llama al servicio de autenticación
        $result = $this->authService->authenticate();


        $token = $request->bearerToken();

        $currentRoute = $request->route;
        $permissions  = $result['user']->rol->permissions;

        // // Verificar si la ruta actual está dentro de los permisos del usuario
        $hasPermission = $permissions->contains(function ($permission) use ($currentRoute) {
            return $permission->route == $currentRoute;
        });

        // Si no tiene permiso para la ruta, devuelve un error 401
        if (! $hasPermission) {
            return response()->json(['message' => 'No Permitido'], 403);
        }
   

        // Si la autenticación es exitosa, devuelve el token, el usuario y la persona
        return response()->json([
            'token'   => $token,
            'user'    => new UserResource($result['user']),
            'message' => 'Autenticado',
        ]);
    }

    public function validatemail(Request $request)
    {
        // Validar la autorización fija
        $authHeader = $request->header('Authorization');

        if ($authHeader != 'Bearer ZXCV-CVBN-VBNM') {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $email = $request->email;

        // Verificar si el correo ya está registrado
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json(['message' => 'Este correo ya ha sido Verificado'], 422);
        }

                                            // Generar un token aleatorio
        $token = bin2hex(random_bytes(16)); // Token de 32 caracteres
        Cache::put("email_verification_token:{$email}", $token, 120);

        Mail::to($email)->send(new SendTokenMail($token));

        return response()->json(['status' => 'success'], 200);
    }

    // Función para registrar al usuario utilizando el token
    public function registerUser(Request $request)
    {
        $name     = $request->name;
        $lastname = $request->lastname;
        $password = $request->password;
        $email    = $request->email;
        $token    = $request->token;

        // Validar que el token esté vigente
        $cachedToken = Cache::get("email_verification_token:{$email}");

        if ($cachedToken != $token) {
            return response()->json(['message' => 'Token inválido o expirado'], 422);
        }

        // Eliminar el token de la caché después de usarlo

        // Crear el usuario en la base de datos
        $user = User::create([
            'first_name' => $name ?? '',
            'last_name'  => $lastname ?? '',
            'email'      => $email,
            'rol_id'     => 2,
            'password'   => Hash::make($password), // Asegúrate de recibir una contraseña segura
        ]);
        Cache::forget("email_verification_token:{$email}");

        return response($user, 200);
    }

}

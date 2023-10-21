<?php

namespace App\Http\Controllers;



use Auth;
use Validetor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Collection;

//use App\Imports\UserImport;

//prueba email
use App\Mail\AccountCreated;
use App\Notifications\UserRegistered;
use Illuminate\Support\Facades\Mail;

class JWTController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function listUsers()
    {
        //muestra todos los usuaros
        $user = DB::table('users')->get();
        return $user;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|min:2|max:100',
            'lastName' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'phoneNumber' => 'required|string|min:2|max:100',
            'password' => 'required|string|min:6',
            'birthDate' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'birthDate' => $request->birthDate,
            'password' => Hash::make($request->password),
        ]);

        //envio email

        //Mail::to($user->email)->send(new AccountCreated($user));
        $user->notify(new UserRegistered($user));

        return response()->json([
            'message' => 'Usuario registrado con exito',
            'user' => $user
        ], 201);
    }


    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Wrong email or password'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 1440,


            "user" => [
                "ciNumber" => auth('api')->user()->ciNumber,
                "firstName" => auth('api')->user()->firstName,
                "lastName" => auth('api')->user()->lastName,
                "email" => auth('api')->user()->email,
                "phoneNumber" => auth('api')->user()->phoneNumber,
                "email_verified_at" => auth('api')->user()->email_verified_at,
                //nos vota el la informacion del usuario y hace que se almacene en el local storage evita consultas continuas
            ],
            "idUser" => auth('api')->user()->idUser,
            "ciNumber" => auth('api')->user()->ciNumber,
            "firstName" => auth('api')->user()->firstName,
            "lastName" => auth('api')->user()->lastName,
            "email" => auth('api')->user()->email,
        ]);
    }

    public function updatePassword(Request $request)
    {
        // Validación
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',

        ]);

        // Obtener el usuario autenticado
        $user = JWTAuth::parseToken()->authenticate();

        // Verificar la contraseña anterior
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'La contraseña anterior es incorrecta'], 401);
        }

        // Actualizar la nueva contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }

    public function userById(Request $request)  // obtener users por id
    {
        $user = DB::table('users')->where('idUser', '=', $request->idUser)
            ->select('users.idUser', 'users.ciNumber', 'users.firstName', 'users.lastName', 'users.email', 'users.phoneNumber', 'users.role', 'users.address', 'users.profilePicture', 'users.birthDate')
            ->get();

        return $user;
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

 /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $input = $request->validated();

            $password = md5($input['password']);
            $credentials = [
                "login"     => $input['login'],
                "password"  => $password
            ];

            $dataUser = User::where("login", $credentials['login'])->where("password", $credentials['password'])->first();

            if(!$dataUser) throw new \Exception("Login or password are wrong.", 401);

            $token = auth()->login($dataUser);

            return response()->json([
                "status"    => true,
                'message' => "Request successfully completed!",
                "data"      => $this->respondWithToken($token)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }

    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();

            return response()->json([
                "status"    => true,
                'message'   => "Request successfully completed!",
                'data'      => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => "Failed when trying to perform request",
                "data"    => $e->getMessage()
            ], $e->getCode() ?: 500);
        }

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
        $user = auth()->user();

        unset($user['password']);

        return [
            'user'         => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}

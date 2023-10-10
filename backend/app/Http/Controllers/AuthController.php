<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

use App\Services\AuthService;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $credentials = $this->authService->validateRegister($request);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);

        $token = $this->authService->createToken($user);

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request){

        $credentials = $this->authService->validateLogin($request);
        $token = $this->authService->generateToken($credentials);
        if ($token){
            return response()->json(['token' => $token],200);
        }

        return response()->json(['message' => 'Invalid credentials'],401);
    }

    public function logout(Request $request)
    {
        $this->authService->deleteToken($request->user());
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}

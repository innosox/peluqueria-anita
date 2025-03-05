<?php

namespace App\Http\Controllers;

use App\Exceptions\Custom\ConflictException;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Traits\RestResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    use RestResponse;

    /**
     * @var AuthRepository
     */
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }


    public function login(LoginRequest $request)
    {
        return $this->success($this->authRepository->login($request));
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

        } catch (Throwable $e) {
            DB::rollBack();
            throw new ConflictException($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }


}

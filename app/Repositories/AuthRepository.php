<?php

namespace App\Repositories;


use App\Exceptions\Custom\ConflictException;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RolPermissionResourse;
use App\Models\Permissions;
use App\Models\RoleHasPermission;
use App\Traits\RestResponse;
use JsonException;

class AuthRepository  {

    use RestResponse;


    /**
     * @param Request $request
     * @return JsonResponse|mixed
     * @throws JsonException
     */
    public function login(Request $request)
    {

        #almaceno emaiil y pass en la variable
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            throw new ConflictException(__('messages.auth-invalid'));
        }

        #GENERAR TOKEN
        $token = Auth::user()->createToken('auth_token')->plainTextToken;

       $dataUser = User::find(Auth::user()->id);
        return $this->success([
            "user" => $dataUser, //Auth::user(),
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }




}

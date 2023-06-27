<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        // login process
        try {
            $request = $request->only(['email', 'password']);
            $token = auth('api')->attempt($request);

            if (!$token) {
                throw new Exception('Login Fail');
            }
            $user = User::where('email', $request['email'])->firstOrFail();

            DB::beginTransaction();

            // $user->token = $token;
            // $user->save();

            DB::commit();

            return $this->respondWithToken($token);
            // return response()->json([
            //     'token' => $token,
            //     'roles' => $user->getRoleNames()->first(),
            //     'userInfo' => [
            //         'username' => $user->first_name . ' ' . $user->last_name
            //     ],
            //     'status' => true,
            //     'message' => 'Login Success'
            // ]);
        } catch (Exception $e) {
            throw $e;
        }
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
        $user = auth('api')->user();

        return response()->json([
            'token' => $token,
            'userInfo' => [
                'username' => $user->first_name . ' ' . $user->last_name
            ],
            'status' => true,
            'message' => "Login Success"
            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}

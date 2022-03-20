<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\LogoutPostRequest;
use App\Http\Requests\UpdatePassPutRequest;
use App\Http\Requests\UpdateUserPutRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function optimize()
    {
        Artisan::call('optimize');
        return "optimizado";
    }

    private function generate_string($input, $strength = 16)
    {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    public function login(LoginPostRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);
            $token = null;
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Credenciales incorrectas',
                    'message' => 'Credenciales incorrectas ',
                ], Response::HTTP_UNAUTHORIZED);
            } else {

                $user = Auth::user();
                $user->device_token = $token;
                $user->save();

                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'device_token' => $user->device_token,
                    'role' => $user->role,
                    'status' => $user->status,
                ];

                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'message' => 'El usuario ha sido autenticado',
                ], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            // $e->getMessage()
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor',
                'message' => 'Error interno del servidor',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }



    }

    public function logout(LogoutPostRequest $request)
    {
        try {
            $user = Auth::user();
            JWTAuth::invalidate($request->device_token);
            $user->device_token = '';
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Session Cerrada',
            ], Response::HTTP_OK);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Error Interno',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateUserPutRequest $request)
    {
        try {
            $user = Auth::user();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'device_token' => $user->device_token,
                'role' => $user->role,
                'status' => $user->status,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Usuario Actualizado con exito',
                'data' => $data,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Error interno del servidor',
            ], 500);
        }
    }

    public function updatePass(UpdatePassPutRequest $request)
    {
        try {
            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password Actualizado con exito',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error Password',
                'message' => 'Error interno del servidor',
            ], 500);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $code = $this->generate_string(time(), 8);
                $user->password = bcrypt($code);
                $user->save();

                $details = [
                    'code' => $code
                ];

                \Mail::to($request->email)->send(new \App\Mail\ForgotPasswordMail($details));

                return response()->json([
                    'success' => true,
                    'message' => 'Password Actualizado con exito',
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Error Password',
                    'message' => 'Error interno del servidor',
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error Password',
                'message' => 'Error interno del servidor',
            ], 500);
        }
    }

    public function getUser()
    {
        try {
            $user = Auth::user();

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'device_token' => $user->device_token,
                'role' => $user->role,
                'status' => $user->status,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Usuario obtenido con exito',
                'data' => $data,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor',
                'message' => 'Error interno del servidor',
            ], 500);
        }
    }

    public function register(Request $request)
    {

        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        //     'role' => 'usuario',
        //     'status' => 1
        // ]);

        return response()->json([
            'success' => true,
            'message' => $request->all(),
        ], 201);
    }

    public function checkToken()
    {
        return response()->json([
            'success' => true,
            'message' => 'Token valido',
        ], 200);
    }
}

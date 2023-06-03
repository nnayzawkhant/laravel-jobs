<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class UserAPIController extends Controller
{
    /**
     * Create new user account.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if( $validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $form_data = $request->only('name','email', 'password');
        $form_data['password'] = Hash::make($form_data['password']);
        $user = User::create($form_data);

        $token = auth()->login($user);

        return response()->json([
                'access_token'=>$token,
                'user'=>$user,
                'success' => true,
                'message' => 'Account creation Ok',
            ]);
    }

    /**
     * Login into application.
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Your password is not correct!'
            ], 401);
        }

        return $this->respondWithToken($token);
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
            'success'=>true,
            'message'=> 'Successfully Authorized',
            'user'=>auth()->user(),
            'access_token' => $token
        ]);
    }



}

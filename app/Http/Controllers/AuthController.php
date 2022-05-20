<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

//use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function username(){
        return 'username';
    }


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //aqui definimos que não terá token em login nem em register
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        //$credentials = request(['email', 'password']);
        $credentials = $request->only('username', 'password');


        //if (! $token = auth()->attempt($credentials)) {
        if (!$token = Auth::guard('api')->attempt($credentials) ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $this->respondWithToken($token);


    }



    public function register(Request $request){
        $user = User::where('username', $request->username)->first();

        if(!$user){
            $user = new User();
            $user->fullname = $request->username;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->image = "";
            $user->activated = 1;
            $user->save();
            return response()->json(["message" => "User created successful","user" => $user]);
        }else{
            return response()->json(["message" => "Error: User not created.", 404]);
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        //auth()->logout();
        //$this->guard()->logout();
        auth("api")->logout();


        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth("api")->refresh());
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
        $user = User::with("employees")->where("id", auth('api')->user()->id)->first();

        return response()->json([
            'user' => $user,
            //'employee' => auth('api')->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("api")->factory()->getTTL() * 60
        ]);
    }


}

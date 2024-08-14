<?php
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Tymon\JWTAuth\Facades\JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;

// class AuthController extends Controller
// {
//     /**
//      * Create a new AuthController instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         // Applying auth middleware except for the login method
//         $this->middleware('auth:api', ['except' => ['login']]);
//     }

//     /**
//      * Get a JWT via given credentials.
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function login(Request $request)
//     {
//         // Validate the incoming request
//         $credentials = $request->only(['email', 'password']);

//         try {
//             // Attempt to authenticate the user and get the token
//             if (! $token = JWTAuth::attempt($credentials)) {
//                 // Return unauthorized error if credentials are invalid
//                 return response()->json(['error' => 'Unauthorized'], 401);
//             }
//         } catch (JWTException $e) {
//             // Return error if there was an issue creating the token
//             return response()->json(['error' => 'Could not create token'], 500);
//         }

//         // Return the token if authentication was successful
//         return $this->respondWithToken($token);
//     }

//     /**
//      * Get the authenticated User.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function me()
//     {
//         // Return the authenticated user
//         return response()->json(JWTAuth::user());
//     }

//     /**
//      * Log the user out (Invalidate the token).
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function logout()
//     {
//         // Invalidate the token
//         JWTAuth::invalidate(JWTAuth::getToken());

//         // Return a success message
//         return response()->json(['message' => 'Successfully logged out']);
//     }

//     /**
//      * Refresh a token.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function refresh()
//     {
//         // Refresh the JWT token
//         return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
//     }

//     /**
//      * Get the token array structure.
//      *
//      * @param string $token
//      * @return \Illuminate\Http\JsonResponse
//      */
//     protected function respondWithToken($token)
//     {
//         $ttl = config('jwt.ttl');
//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'bearer',
//             'expires_in' => $ttl * 60
//         ]);
//     }
// }
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login', 'signup']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validateData=$request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or password is invalid'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->login($request);
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
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // return $this->respondWithToken(auth()->refresh());
        return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
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
        $ttl = config('jwt.ttl');
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 1,
            'name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
            'email' => auth()->user()->email,
        ]);
    }
}

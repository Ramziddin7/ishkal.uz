<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


      /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/login",
     * summary="Log in user ",
     * description="Login by email, password !",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Balance history  credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"email","password"},
     *       @OA\Property(property="email", type="email", format="string", example="user@gmail.com"),
     *       @OA\Property(property="password", type="text", format="string", example="1234567890AA"),
     *    ),
     *    ),
     * ),
     *@OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * )
     * )
     */


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth()->guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
                'data' => null,
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'success' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    
      /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/register",
     * summary="Register ",
     * description="Register user !",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass User history  credentials",
     *   @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"email","password","password_confirmation","name"},
     *       @OA\Property(property="name", type="text", format="string", example="Jon Doe"),
     *       @OA\Property(property="email", type="email", format="string", example="user@gmail.com"),
     *       @OA\Property(property="password", type="text", format="string", example="1234567890AA"),
     *       @OA\Property(property="password_confirmation", type="password", format="string", example="1234567890AA"),
     *    ),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * )
     */



    public function register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8','confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth()->guard('api')->login($user);
        return response()->json([
            'success' => 'success',
            'message' => 'User created successfully',
            'data' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ],200);
    }




         /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/logout",
     * summary="Logout ",
    *  security={{ "api": {} }},
     * description="logout user !",
     * tags={"Auth"},
     *@OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * )
     */

    public function logout()
    {
        Auth()->guard('api')->logout();
        return response()->json([
            'success' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'success' => 'success',
            'data' => Auth()->guard('api')->user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ],200);
    }

 
}

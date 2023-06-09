<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\Categories;
use App\Models\Chat;
use App\Models\Customer;
use App\Models\Messages;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * @param SignupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(SignupRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['password']);
            $data['application'] = false;

            $customer = Customer::create($data);
            $token = JWTAuth::fromUser($customer);
            $categories = Categories::all();
            $chats = [];
            foreach ($categories as $category) {
                if($category->name === 'Познакомь Искусственный Интеллект MSU с собой.') {
                    $chat = Chat::create([
                        'customer_id' => $customer->id,
                        'category_id' => $category->id,
                        'is_default' => true,
                        'acquaintance' => true,
                        'name' => $category->name,
                    ]);
                    $chats[] = $chat;
                } else {
                    $chat = Chat::create([
                        'customer_id' => $customer->id,
                        'category_id' => $category->id,
                        'is_default' => true,
                        'acquaintance' => false,
                        'name' => $category->name,
                    ]);
                    $chats[] = $chat;
                }
            }
            return response()->json([
                'customer' => $customer,
                'access_token' => $token,
                'status' => true,
                '$chats' => $chats,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Wrong Login or Password!'], 422);
        }

        return $this->respondWithToken($token);
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
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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
            'customer' => auth('api')->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}

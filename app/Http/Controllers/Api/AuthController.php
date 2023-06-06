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

<<<<<<< HEAD
            $customer = Customer::create([
                ...$data,
                'questionnaire' => false
            ]);
=======
            $customer = Customer::create($data);
>>>>>>> ce94189ead7d4232bf00110093f9a1118b137715

            $token = JWTAuth::fromUser($customer);
            $categories = Categories::all();
            $chats = [];
            foreach ($categories as $category) {
                $chat = Chat::create([
                    'customer_id' => $customer->id,
                    'category_id' => $category->id,
                    'is_default' => true,
                    'name' => $category->name,
                ]);
                $chats[] = $chat;
            }
            foreach ($chats as $chat) {
                if($chat->name === 'Познакомь Искусственный Интеллект MSU с собой.') {
                    Messages::create([
                        'message' => 'Когда, во время прохождения программы, у тебя будут появляться инсайты, новые компетенции, открываться твои сильные стороны, появится твой уникальный дар, то обязательно дополняй информацию о себе в этой категории.',
                        'is_user' => false,
                        'chat_id' => $chat->id,
                        'customer_id' => $customer->id,
                    ]);
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Services\OpenAiService;
use App\Models\Chat;
use App\Models\Messages;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        try {
            $question = OpenAiService::sendQuestion($request->message);
            if ($question && $question['choices'] && $question['choices'][0]) {
                $answer = $question['choices'][0]['message']['content'];
                $chat = Chat::find($request->chat_id);
                if(!$chat) {
                    $chat = Chat::create([
                        'customer_id' => auth('api')->user()->id,
                        'name' => $request->name ? $request->name : 'New',
                    ]);
                }

                Messages::create([
                    'message' => $request->message,
                    'is_user' => true,
                    'chat_id' => $chat->id,
                    'customer_id' => auth('api')->user()->id,
                ]);

                $message = Messages::create([
                    'message' => $answer,
                    'is_user' => false,
                    'chat_id' => $chat->id,
                    'customer_id' => auth('api')->user()->id,
                ]);

                return response()->json([
                    'data' => new MessageResource($message),
                    'chat' => $chat,
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'data' => 'Server Error',
                    'status' => true,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages($id)
    {
        try {
            $messages = Messages::where('chat_id', $id)
                ->where('customer_id', auth('api')->user()->id)->orderBy('id', 'asc')->get();

            return response()->json([
                'data' => $messages,
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function getChats()
    {
        try {
            $customer_id = auth('api')->id();
            $chats = Chat::with('customer')->where('customer_id',$customer_id)->get();

            return response()->json([
                'data' => $chats,
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $chat = Chat::find($id);
            $chat->name = $request->name;
            $chat->save();

            return response()->json([
                'data' => $chat->load('customer'),
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}

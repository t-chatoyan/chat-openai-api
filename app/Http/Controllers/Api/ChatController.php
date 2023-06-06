<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Services\OpenAiService;
use App\Models\Categories;
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
                    $category = Categories::create([
                        'name' => $request->name ? $request->name : 'New',
                    ]);

                    $chat = Chat::create([
                        'customer_id' => auth('api')->user()->id,
                        'category_id' => $category->id,
                        'is_default' => false,
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendApplication(Request $request)
    {
        try{
            $customer = auth('api')->user();
            $customer->update([
<<<<<<< HEAD
                'questionnaire' => true
=======
                'application' => true
>>>>>>> ce94189ead7d4232bf00110093f9a1118b137715
            ]);
            $customer_id = $customer->id;
            $chat = Chat::where(['name' => 'Познакомь Искусственный Интеллект MSU с собой.','customer_id' => $customer_id])->get();
            $chat_id = $chat[0]->id;
            $messages = [
                'Начинай пользоваться возможностями искусственного интеллекта для себя.',
                'Обязательно отвечай на все вопросы честно и откровенно, потому что это будет влиять на твои результаты. Алгоритм будет подбирать специально под тебя решение. Если твои ответы врут, то и решения будут некачественными и не подходящими для тебя. Поэтому старайся быть максимально предельно честным по отношению к себе. И тогда алгоритм подберет для тебя точечное фокусное решение, которое будет для тебя приносить максимальный результат.',
                'Внутри твоего помощника все распределено по категориям с возможностью создать свою персональную категорию.',
                'Если твой вопрос касается конкретной категории, начинай обсуждение в категории к какой он относится.',
                'Задавай и отвечай на вопросы как можно полнее и вноси свою индивидуальность, таким образом ты будешь персонализировать цифрового помощника под себя.',
                'Пользуйся кнопкой “Связаться с куратором”, если возникают дополнительные вопросы.',
                'Приложение работает как на ПК, так и на смартфоне.Задавать вопросы, ведущие к нарушению закона - запрещено.',
                'Приложение работает как на ПК, так и на смартфоне.',
                'Задавать вопросы, ведущие к нарушению закона - запрещено.',
                'Подключайся к нашему комьюнити в телеграм https://t.me/metaspeed	up ',
                'Срок доступа к помощнику: помощник доступен все время прохождения программы + 1 мес. после окончания',
            ];
            foreach ($messages as $message){
                Messages::create([
                    'message' => $message,
                    'is_user' => false,
                    'chat_id' => $chat_id,
                    'customer_id' => auth('api')->user()->id,
                ]);
            }
            return response()->json([
               'chat_id' => $chat[0]->id,
               'status' => true,
               'message' => 'Your form is completed',
            ],200);
        } catch (\Exception $e) {
        return response()->json([
            'messages' => $e->getMessage(),
            'status' => false,
        ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Services\OpenAiService;
use App\Models\Categories;
use App\Models\Chat;
use App\Models\Customer;
use App\Models\Messages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Symfony\Component\String\length;

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

            $chat = Chat::find($request->chat_id);
            if (!$chat) {
                $chat = Chat::create([
                    'customer_id' => auth('api')->user()->id,
                    'is_default' => false,
                    'name' => $request->name ? $request->name : null,
                ]);
            }

            Messages::create([
                'message' => $request->message,
                'is_user' => true,
                'is_default' => false,
                'chat_id' => $chat->id,
                'customer_id' => auth('api')->user()->id,
            ]);

            if ($question && $question['choices'] && $question['choices'][0]) {
                $answer = $question['choices'][0]['message']['content'];


                $message = Messages::create([
                    'message' => $answer,
                    'is_default' => false,
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDefaultMessages($id)
    {
        try {
            $defaultMessages = Messages::where('chat_id', $id)
                ->where('customer_id', auth('api')->user()->id)->orderBy('id', 'asc')->get();

            $setMessages = Messages::where('chat_id', $id)
                ->where('customer_id', auth('api')->user()->id)->orderBy('id', 'asc')->get();

            foreach ($setMessages as $message) {
                $message->update([
                    'is_default' => false,
                ]);
            }

            return response()->json([
                'data' => $defaultMessages,
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
            $chats = Chat::with('customer')->where('customer_id', $customer_id)->get();

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
        try {
            $customer_id = auth('api')->id();
            $customer = Customer::where('id', $customer_id)->update([
                'application' => true
            ]);

            $chat = Chat::where(['acquaintance' => 1,'customer_id' => auth('api')->id()])->get();
            $chat_id = $chat[0]->id;
            $messages = [
                'Добро пожаловать в искусственный интеллект MetaSpeedUp',
                'Когда, во время прохождения программы, у тебя будут появляться инсайты, новые компетенции, открываться твои сильные стороны, появится твой уникальный дар, то обязательно дополняй информацию о себе в этой категории.',
                'Начинай пользоваться возможностями искусственного интеллекта для себя.',
                'Обязательно отвечай на все вопросы честно и откровенно, потому что это будет влиять на твои результаты. Алгоритм будет подбирать специально под тебя решение. Если твои ответы врут, то и решения будут некачественными и не подходящими для тебя. Поэтому старайся быть максимально предельно честным по отношению к себе. И тогда алгоритм подберет для тебя точечное фокусное решение, которое будет для тебя приносить максимальный результат.',
                'Внутри твоего помощника все распределено по категориям с возможностью создать свою персональную категорию.',
                'Если твой вопрос касается конкретной категории, начинай обсуждение в категории к какой он относится.',
                'Задавай и отвечай на вопросы как можно полнее и вноси свою индивидуальность, таким образом ты будешь персонализировать цифрового помощника под себя.',
                'Пользуйся кнопкой “Связаться с куратором”, если возникают дополнительные вопросы.',
                'Приложение работает как на ПК, так и на смартфоне.',
                'Задавать вопросы, ведущие к нарушению закона - запрещено.',
                'Подключайся к нашему комьюнити в телеграм https://t.me/metaspeedup',
                'Срок доступа к помощнику: помощник доступен все время прохождения программы + 1 мес. после окончания',
            ];
            foreach ($messages as $index => $message) {
                $seconds = ($index + 1) * 3;
                Messages::create([
                    'message' => $message,
                    'is_user' => false,
                    'is_default' => true,
                    'chat_id' => $chat_id,
                    'customer_id' => auth('api')->user()->id,
                    'created_at' => Carbon::now()->addSecond($seconds)
                ]);
            }

            return response()->json([
                'chat_id' => $chat[0]->id,
                'status' => true,
                'message' => 'Your form is completed',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}

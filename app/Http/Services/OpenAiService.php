<?php

namespace App\Http\Services;


use Illuminate\Support\Facades\Http;

class OpenAiService
{
    /**
     * @param $question
     * @return mixed
     */
    public static function sendQuestion($question){

        $api_key = env('OPENAI_API_KEY');
        $api_endpoint = "https://api.openai.com/v1/chat/completions";
        $request_body = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "system", "content" => "My name is MSU"],
                ["role" => "system", "content" => "I was created by MSU team."],
                ["role" => "user", "content" => $question],
            ],
            "temperature" => 0,
            "max_tokens" => 3000, // 4096
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
        ])->post($api_endpoint , $request_body);
        dd($response->json());
        return $response->json();
    }
}

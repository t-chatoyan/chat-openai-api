<?php

namespace App\Http\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class OpenAiService
{
    public static function sendQuestion($question){

        $api_key = env('OPENAI_API_KEY');
        $api_endpoint = "https://api.openai.com/v1/chat/completions";

        $request_body = [
            "model" => "gpt-3.5-turbo",
            "messages" => [["role" => "user", "content" => $question]],
            "temperature" => 0,
            "max_tokens" => 100,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
        ])->post($api_endpoint , $request_body);
        return $response->json();
    }
}

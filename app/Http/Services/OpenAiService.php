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
        set_time_limit(0);
        $api_key = env('OPENAI_API_KEY');
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

        $api_endpoint = "https://api.openai.com/v1/chat/completions";
        $data = json_encode($request_body);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1000000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $api_key, 'Content-Type:application/json']);
        $curl_response = curl_exec($ch);

        $result = json_decode($curl_response,true);

        return $result;
    }
}

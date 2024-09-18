<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ChatGptController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(); // Create a new Guzzle client
    }

    public function showAichatgpt()
    {
        return view('app.show-chatgptai-view');
    }

    // public function showResponse(Request $request)
    // {
    //     $message = $request->input('message');
    //     $apiKey = env('OPENAI_API_KEY'); // Get the API key from the .env file
    //     dd($apiKey);
    //     if (!$apiKey) {
    //         return Response::json([
    //             'status' => 'error',
    //             'message' => 'API key is missing',
    //         ], 500);
    //     }

    //     try {
    //         // Make a request to the OpenAI API
    //         $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $apiKey,
    //                 'Content-Type' => 'application/json',
    //             ],
    //             'json' => [
    //                 'model' => 'gpt-3.5-turbo',
    //                 'messages' => [
    //                     ['role' => 'system', 'content' => 'You are a helpful assistant.'],
    //                     ['role' => 'user', 'content' => $message],
    //                 ],
    //             ],
    //         ]);

    //         // Convert the response to JSON
    //         $responseBody = json_decode($response->getBody(), true);

    //         // Return the API response
    //         return Response::json([
    //             'status' => 'success',
    //             'data' => $responseBody['choices'][0]['message']['content'],
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Handle any errors
    //         return Response::json([
    //             'status' => 'error',
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function showResponseWithImage(Request $request)
    {
        $message = $request->input('message', ''); 
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return Response::json([
                'status' => 'error',
                'message' => 'API key is missing',
            ], 500);
        }

        try {
            $response = $this->client->post('https://api.openai.com/v1/images/generations', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'prompt' => $message, 
                    'n' => 1,
                    'size' => '1024x1024', 
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);

            return Response::json([
                'status' => 'success',
                'data' => $responseBody['data'][0]['url'], 
            ], 200);
        } catch (\Exception $e) {
            return Response::json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

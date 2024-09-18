<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;

class ShowChatGptAi extends Component
{

    public $message;
    public $response;
    public $api_key = '';

    public function sendMessage()
    {
        $client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
        ]);

        try {
            $response = $client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->api_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo', 
                    'messages' => [
                        ['role' => 'user', 'content' => $this->message],
                    ],
                    'max_tokens' => 50, 
                    'temperature' => 0.7,
                ],
            ]);

            $this->response = json_decode($response->getBody(), true)['choices'][0]['message']['content'];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->response = 'Client error: ' . $e->getResponse()->getBody()->getContents();
        } catch (\Exception $e) {
            $this->response = 'Error: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.show-chat-gpt-ai');
    }
}

<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected $client;
    protected $botToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.telegram.org/bot' . env('TELEGRAM_LOGS_BOT_TOKEN') . '/'
        ]);
    }

    public function sendMessage($chatId, $message)
    {
        try {
            $response = $this->client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $chatId,
                    'text' => $message
                ],
                'verify' => false
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram send message error: ' . $e->getMessage());
            return false;
        }
    }
}

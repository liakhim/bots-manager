<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $client;
    protected $botToken;
    protected $chatId;

    public function __construct($botToken, $chatId)
    {
        $this->botToken = $botToken;
        $this->chatId = $chatId;
        $this->client = new Client([
            'base_uri' => 'https://api.telegram.org/bot' . $this->botToken . '/'
        ]);
    }

    public function sendMessage($message)
    {
        $keyboard = [['1', '2', '3', '4', '5']];
        try {
            $response = $this->client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                    'reply_markup' => json_encode([
                        'keyboard' => $keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ])
                ],
                'verify' => false
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Telegram send message error: ' . $e->getMessage());
            return false;
        } catch (GuzzleException $e) {
            Log::error('Telegram send (GuzzleException) message error: ' . $e->getMessage());
            return false;
        }
    }
}

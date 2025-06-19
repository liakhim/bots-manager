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

    public function sendMessage($message, $reply_markup = null)
    {
        try {
            $response = $this->client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                    'reply_markup' => $reply_markup
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

    public function sendMessageAsCode($message, $reply_markup = null)
    {
        try {
            $response = $this->client->post('sendMessage', [
                'form_params' => [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                    'parse_mode' => 'MarkdownV2',
                    'reply_markup' => $reply_markup
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

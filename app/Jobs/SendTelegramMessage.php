<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $message;
    private string $botToken;

    public function __construct(string $message, string $bot_token)
    {
        $this->message = $message;
        $this->botToken = $bot_token;
    }

    public function handle(): void
    {
        $telegram = new TelegramService($this->botToken, env('TELEGRAM_EVERY_DAY_CHAT_ID'));
        $telegram->sendMessage($this->message);
    }
}

<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected string $message;
    protected string $bot_token;

    public function __construct(User $user, string $message, string $bot_token)
    {
        $this->user = $user;
        $this->message = $message;
        $this->botToken = $bot_token;
    }

    public function handle(): void
    {
        $telegram = new TelegramService($this->botToken, $this->user->chat_id);
        $telegram->sendMessage($this->message);
    }
}

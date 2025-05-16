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

    protected User $user;
    protected string $message;

    public function __construct(User $user, string $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function handle(): void
    {
        $telegram = new TelegramService('7702828915:AAFXDdjc4urnXR1LdYVLLyhEP7t3GvXf3Lw', $this->user->chat_id);
        $telegram->sendMessage($this->message);
    }
}

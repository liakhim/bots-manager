<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class LogTimeCommand extends Command
{
    protected $signature = 'log:time';
    protected $description = 'Log current time to the Laravel log';

    public function handle()
    {
        $telegram = new TelegramService(env('TELEGRAM_LOGS_BOT_TOKEN'), env('TELEGRAM_LOGS_CHAT_ID'));
        $telegram->sendMessage('Current time: ' . now()->toDateTimeString());
        $this->info('Time logged successfully!');
    }
}

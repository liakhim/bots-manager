<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class MorningGreetingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:morning-greeting-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $telegram = new TelegramService();
        $start_message = "
Привет, {user_name}! 😊

Не забудь отправить сегодняшнее фото! 📸✨
Это займет всего секунду, но так важно для твоего прогресса!

Напоминаю: загружай фото каждый день примерно в одно время. Буду ждать твой сегодняшний снимок! ❤️
";
        $telegram->sendMessage(env('TELEGRAM_LOGS_CHAT_ID'), $start_message);
        $this->info('Time logged successfully!');
    }
}

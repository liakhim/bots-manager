<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        try {
            $telegram = new TelegramService('7702828915:AAFXDdjc4urnXR1LdYVLLyhEP7t3GvXf3Lw', env('TELEGRAM_LOGS_CHAT_ID'));
            $start_message = "
Привет, {user_name}! 😊

Не забудь отправить сегодняшнее фото! 📸✨
Это займет всего секунду, но так важно для твоего прогресса!

Напоминаю: загружай фото каждый день примерно в одно время. Буду ждать твой сегодняшний снимок! ❤️
";
            $telegram->sendMessage($start_message);
        } catch (\Exception $e) {
            $data = json_encode($e->getTraceAsString());
            isset($telegram) ? $telegram->sendMessage($data) : Log::error(json_encode($e->getTraceAsString())) ;
        }
        $this->info('Time logged successfully!');
    }
}

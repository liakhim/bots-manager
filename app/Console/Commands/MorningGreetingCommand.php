<?php

namespace App\Console\Commands;

use App\Jobs\SendTelegramMessage;
use App\Models\User;
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
        $users = User::all();

        $message = "
Привет, {user_name}! 😊

Не забудьте отправить сегодняшнее фото! 📸✨
Это займет всего секунду, но так важно для твоего прогресса!

Напоминаем: загружай фото каждый день примерно в одно время. Будем ждать твой сегодняшний снимок! ❤️
";

        foreach ($users as $user) {
            SendTelegramMessage::dispatch($user, $message);
        }

        $this->info('Time logged successfully!');
    }
}

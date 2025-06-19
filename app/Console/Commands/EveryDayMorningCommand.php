<?php

namespace App\Console\Commands;

use App\Jobs\SendEveryDayTelegramMessage;
use Illuminate\Console\Command;

class EveryDayMorningCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:morning-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for counting every day work time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = "
Ежедневное сообщение о начале рабочего дня
";

        SendEveryDayTelegramMessage::dispatch($message, env('TELEGRAM_EVERY_DAY_BOT'));

        $this->info('Time logged successfully!');
    }
}

<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LogTimeCommand extends Command
{
    protected $signature = 'log:time';
    protected $description = 'Log current time to the Laravel log';

    public function handle()
    {
        $word = DB::table('b2_words')->inRandomOrder()->first();
        $telegram = new TelegramService(env('TELEGRAM_LOGS_BOT_TOKEN'), env('TELEGRAM_LOGS_CHAT_ID'));
        $definitions = [];
        $data = "```json\n" . json_encode([
                'Слово' => $word->word,
                'Данные' => $word->meanings,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)  . "\n```";
        $telegram->sendMessageAsCode($data);
        $this->info('Time logged successfully!');
    }
}

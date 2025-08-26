<?php

namespace App\Console\Commands;

use App\Models\B2Word;
use App\Models\B2WordsDefinition;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogTimeCommand extends Command
{
    protected $signature = 'log:time';
    protected $description = 'Log current time to the Laravel log';

    function escapeMarkdownV2($text) {
        $chars = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        foreach ($chars as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
        return $text;
    }

    public function handle()
    {
        /** @var B2Word $word */
        $word = DB::table('b2_words')->inRandomOrder()->first();

        $telegram = new TelegramService(env('TELEGRAM_LOGS_BOT_TOKEN'), env('TELEGRAM_LOGS_CHAT_ID'));
        $data = "```json\n" . json_encode([
                'Слово' => $word->word,
                'Перевод' => $word->word_translation,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)  . "\n```";

        foreach (B2WordsDefinition::where('b2_word_id', $word->id)->get() as $index => $definition) {
            $number = $index + 1;
            $data .= "🌍 ️**Значение {$number}:** {$this->escapeMarkdownV2($definition->body_translation)}\n\n";
        }
        $data .= "\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\n\n";
        foreach (B2WordsDefinition::where('b2_word_id', $word->id)->get() as $index => $definition) {
            $number = $index + 1;
            $data .= "⭐ ️**Пример {$number}:** {$this->escapeMarkdownV2($definition->example)}  \-  {$this->escapeMarkdownV2($definition->example_translation)}\n\n";
        }
        $telegram->sendMessageAsCode($data, null, 'MarkdownV2');
        $this->info('Time logged successfully!');
    }
}

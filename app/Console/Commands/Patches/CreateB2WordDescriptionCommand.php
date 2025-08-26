<?php

namespace App\Console\Commands\Patches;

use App\Models\B2Word;
use App\Services\DictionaryService;
use App\Services\GoogleTranslateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateB2WordDescriptionCommand extends Command
{
    protected $signature = 'b2:create-word-description';
    protected $description = 'Вытаскиваем из api dictionary данные по слову';

    public function handle(): void
    {
        $words = B2Word::all();
        foreach ($words as $word_instance) {
            $meanings = (new DictionaryService($word_instance['word']))->getDescription();

            $word_instance->fill([
                'meanings' => json_encode($meanings, JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_SUBSTITUTE ),
                'word_translation' => (new GoogleTranslateService($word_instance->word))->run()
            ]);
            $word_instance->save();

            foreach ($meanings as $meaning) {
                foreach($meaning['definitions'] as $definition) {
                    $word_instance->definitions()->create([
                        'body' => $definition['body'],
                        'body_translation' => $definition['body_translation'],
                        'example' => $definition['example'],
                        'example_translation' => $definition['example_translation']
                    ]);
                }
            }
        }
        $this->info('Time logged successfully!');
        $this->info(' готово!');
    }
}

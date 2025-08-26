<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class DictionaryService
{
    protected $client;
    protected $word;

    public function __construct($word)
    {
        $this->word = $word;
        $this->client = new Client();
    }

    public function getBody()
    {
        try {
            $response = $this->client->get('https://api.dictionaryapi.dev/api/v2/entries/en/' . urlencode($this->word) . '/' , ['verify' => false]);

            $word_description_data = json_decode($response->getBody(), true);
            $meanings_array = [];
            $d = [];
            foreach ($word_description_data as $index => $word_description) {

//              TODO: доделать audio и phonetic

                foreach ($word_description['meanings'] as $meaning) {
                    foreach ($meaning['definitions'] as $definition) {

                        $translate = (new GoogleTranslateService($definition['definition']))->run();
                        if (isset($definition['example'])) {
                            $example_translate = (new GoogleTranslateService($definition['example']))->run();
                        } else {
                            $example_translate = '';
                        }

                        $d['definitions'][] = [
                            'body' => $definition['definition'],
                            'body_translation' => $translate,
                            'example' => $definition['example'] ?? null,
                            'example_translation' => $example_translate,
                        ];
                    }
                }
                $d['meanings'] = $word_description['meanings'];
                $meanings_array[] = $d;
            }

            Log::info('$meanings_array');
            Log::info(json_encode($meanings_array));

            return $meanings_array;
        } catch (\Exception $e) {
            Log::error('Dictionary getting message error: ' . $e->getMessage());
            return false;
        }
    }

    public function getDescription() {
        return $this->getBody();
    }
}

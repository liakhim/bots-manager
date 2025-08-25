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
            $response = $this->client->get('https://api.dictionaryapi.dev/api/v2/entries/en/' . $this->word . '/' , ['verify' => false]);

            $word_description_data = json_decode($response->getBody(), true);
            $meanings_array = [];
            foreach ($word_description_data as $index => $word_description) {

//                TODO: доделать audio и phonetic
//                foreach ($word_description['phonetics'] as $phonetic) {
//                    Log::info('$phonetic');
//                    Log::info($phonetic);
//                }

                $d = [];
                $d['meanings'] = $word_description['meanings'];
                $meanings_array[] = $d;
            }

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

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateService
{
    protected $phrase;

    public function __construct($phrase)
    {
        $this->phrase = $phrase;
    }
    public function translate(): ?string
    {
        $translator  = new GoogleTranslate();
        $translator->setOptions([
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]
        ]);
        return $translator->setSource('en')->setTarget('ru')->translate($this->phrase);
    }

    public function run(): ?string
    {
        return $this->translate();
    }
}

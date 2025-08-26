<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin Builder
 */
class B2Word extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'word',
        'word_translation',
        'meanings',
        'synonyms',
        'antonyms',
        'examples',
        'audio'
    ];

    public function definitions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(B2WordsDefinition::class);
    }
}

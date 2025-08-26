<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin Builder
 */
class B2WordsDefinition extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'b2_word_id',
        'body',
        'body_translation',
        'example',
        'example_translation',
    ];

    public function word(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(B2WordsDefinition::class);
    }

}

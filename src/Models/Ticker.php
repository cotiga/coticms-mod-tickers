<?php

namespace Cotiga\ModuleTickers\Models;

use Cotiga\CotiCmsCore\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    use HasActivityLog;

    protected $table = 'tickers';

    protected string $activityLabelAttribute = 'texte';

    protected $fillable = [
        'texte', 'lien', 'ordre', 'onl',
    ];

    protected $casts = [
        'onl' => 'boolean',
    ];

    /** Annonces en ligne, ordonnées. */
    public function scopeOnline(Builder $query): Builder
    {
        return $query->where('onl', true)->orderBy('ordre');
    }
}

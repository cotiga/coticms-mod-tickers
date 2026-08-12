<?php

namespace Cotiga\ModuleTickers\Support;

use Cotiga\CotiCmsCore\Models\ModuleSettings;
use Cotiga\ModuleTickers\Models\Ticker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Contenu du bandeau défilant. La source se règle en admin (Paramètres →
 * Activation des modules → Contenu du bandeau) : annonces saisies, événements à
 * venir, ou les deux.
 *
 * Le module événements n'est PAS une dépendance : s'il n'est ni installé ni
 * activé, la source « événements » ne rend rien plutôt que de casser la page.
 */
class TickerSource
{
    /** Longueur de l'extrait d'un événement, en caractères. */
    public const EXTRAIT = 120;

    /** Nombre maximum d'événements repris dans le bandeau. */
    public const MAX_EVENEMENTS = 10;

    private const MODELE_EVENT = \Cotiga\ModuleEvents\Models\Event::class;

    /** Fragments HTML prêts à défiler, dans l'ordre d'affichage. */
    public static function items(): Collection
    {
        $source = ModuleSettings::get()->ticker_source ?: 'tickers';

        $items = collect();

        if ($source !== 'events') {
            $items = $items->concat(static::depuisAnnonces());
        }

        if ($source !== 'tickers') {
            $items = $items->concat(static::depuisEvenements());
        }

        return $items;
    }

    /** Annonces saisies en admin. Le texte est déjà du HTML de confiance. */
    protected static function depuisAnnonces(): Collection
    {
        return Ticker::online()->get()->map(
            fn (Ticker $t) => $t->lien
                ? '<a href="'.e($t->lien).'">'.$t->texte.'</a>'
                : $t->texte
        );
    }

    /** Événements à venir : date, titre, extrait tronqué, lien vers la fiche. */
    protected static function depuisEvenements(): Collection
    {
        if (! class_exists(self::MODELE_EVENT) || ! Route::has('evenements.show')) {
            return collect();
        }

        if (! (ModuleSettings::get()->evenements_actif ?? false)) {
            return collect();
        }

        $modele = self::MODELE_EVENT;

        return $modele::upcoming()
            ->limit(static::MAX_EVENEMENTS)
            ->get()
            ->map(function ($event) {
                $texte = e($event->date_deb->translatedFormat('j M')).' — '.e($event->titre);

                if ($extrait = static::extrait($event->contenu)) {
                    $texte .= ' : '.e($extrait);
                }

                return $texte.' <a href="'.e(route('evenements.show', $event->slug)).'">Voir l\'événement</a>';
            });
    }

    /**
     * Contenu TinyMCE ramené à une phrase de bandeau : balises retirées, entités
     * décodées (sinon « &nbsp; » se lirait tel quel) et espaces repliés — un
     * contenu mis en page multiplie les retours à la ligne.
     */
    protected static function extrait(?string $contenu): string
    {
        $texte = html_entity_decode(strip_tags((string) $contenu), ENT_QUOTES);
        $texte = trim(preg_replace('/\s+/u', ' ', $texte));

        return $texte === '' ? '' : Str::limit($texte, static::EXTRAIT);
    }
}

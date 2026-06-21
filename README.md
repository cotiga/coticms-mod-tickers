# coticms-mod-tickers

Module bandeau d'annonces **défilant** (ticker) pour CotiCMS.

## Installation

```bash
php artisan cotiga:module:install cotiga/module-tickers
```

Puis activer le module dans **Paramètres système → Activation des modules → Module Bandeau d'annonces**.

## Modèle

`Cotiga\ModuleTickers\Models\Ticker` — `texte`, `lien` (optionnel), `ordre`, `onl`. Emojis autorisés (utf8mb4).

Scope `online()` : en ligne, triées par `ordre`.

## Affichage (thème)

```blade
<x-tickers::bar />

{{-- longueur tronquée par item (défaut 80) et classes additionnelles --}}
<x-tickers::bar :limit="60" class="my-2" />
```

- Défilement CSS en boucle (pause au survol, désactivé en `prefers-reduced-motion`).
- CSS publié automatiquement dans `public/vendor/module-tickers/module-tickers.css` (à inclure si le thème ne charge pas les assets vendor).
- Chaque item avec `lien` est cliquable.

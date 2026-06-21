@php
    use Cotiga\ModuleTickers\Models\Ticker;

    /** @var \Illuminate\Support\Collection<int,\Cotiga\ModuleTickers\Models\Ticker> $tickers */
    $tickers = Ticker::online()->get();
@endphp

@if ($tickers->isNotEmpty())
    @once
        @push('styles')
            <link rel="stylesheet" href="{{ asset('vendor/module-tickers/module-tickers.css') }}">
        @endpush
    @endonce

    <div {{ $attributes->merge(['class' => 'coti-ticker']) }} role="region" aria-label="Annonces">
        <div class="coti-ticker__track">
            @foreach ($tickers as $t)
                <span class="coti-ticker__item">
                    @if ($t->lien)
                        <a href="{{ $t->lien }}">{!! $t->texte !!}</a>
                    @else
                        {!! $t->texte !!}
                    @endif
                </span>
            @endforeach
            {{-- Duplication (aria-hidden) pour un défilement en boucle sans coupure --}}
            @foreach ($tickers as $t)
                <span class="coti-ticker__item" aria-hidden="true">
                    @if ($t->lien)
                        <a href="{{ $t->lien }}" tabindex="-1">{!! $t->texte !!}</a>
                    @else
                        {!! $t->texte !!}
                    @endif
                </span>
            @endforeach
        </div>
    </div>
@endif

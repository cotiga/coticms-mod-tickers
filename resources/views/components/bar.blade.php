@props(['speed' => '0.5'])

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

    <div {{ $attributes->merge(['class' => 'coti-ticker']) }} data-speed="{{ $speed }}" data-pausable="true" role="region" aria-label="Annonces">
        <div class="coti-ticker__content">
            @foreach ($tickers as $t)
                <span class="coti-ticker__item">@if ($t->lien)<a href="{{ $t->lien }}">{!! $t->texte !!}</a>@else{!! $t->texte !!}@endif</span>
            @endforeach
        </div>
    </div>

    @once
    @push('scripts')
    <script>
    /* Bandeau défilant : vitesse constante (px/frame), clones pour remplir,
       boucle sans couture, pause au survol. */
    (function () {
        function build(el) {
            var speed = parseFloat(el.dataset.speed) || 0.5;
            var pausable = el.dataset.pausable !== 'false';
            var content = el.children[0];
            if (!content) return null;
            var wrap = document.createElement('div');
            wrap.style.display = 'inline-block';
            wrap.style.whiteSpace = 'nowrap';
            wrap.style.willChange = 'transform';
            content.style.display = 'inline-block';
            content.style.whiteSpace = 'nowrap';
            el.appendChild(wrap);
            wrap.appendChild(content);
            var cw = content.offsetWidth;
            if (!cw) return null;
            var reps = cw > el.offsetWidth ? 1 : Math.ceil(el.offsetWidth / cw) + 1;
            for (var i = 0; i < reps; i++) {
                var clone = content.cloneNode(true);
                clone.setAttribute('aria-hidden', 'true');
                clone.style.display = 'inline-block';
                wrap.appendChild(clone);
            }
            var t = { wrap: wrap, cw: cw, speed: speed, offset: 0, paused: false };
            if (pausable) {
                el.addEventListener('mouseenter', function () { t.paused = true; });
                el.addEventListener('mouseleave', function () { t.paused = false; });
            }
            return t;
        }
        function start() {
            var items = [].map.call(document.querySelectorAll('.coti-ticker'), build).filter(Boolean);
            if (!items.length) return;
            (function loop() {
                for (var i = 0; i < items.length; i++) {
                    var t = items[i];
                    if (t.paused) continue;
                    t.offset -= t.speed;
                    if (t.offset <= -t.cw) t.offset += t.cw;
                    t.wrap.style.transform = 'translateX(' + t.offset + 'px)';
                }
                requestAnimationFrame(loop);
            })();
        }
        if (document.readyState !== 'loading') start();
        else document.addEventListener('DOMContentLoaded', start);
    })();
    </script>
    @endpush
    @endonce
@endif

@php
    $headerEventTypes = \App\Models\EventType::headerMenu()->select('event_type_name', 'id')->orderBy('event_type_name')->get();
    $currentType = request('type');
@endphp

<div class="header-event-types">
    <div class="header-event-types__inner">
        <ul class="header-event-types__list" id="headerEventTypeNav">
            <li>
                <a href="{{ url('/') }}" class="{{ empty($currentType) ? 'active' : '' }}">All Tickets</a>
            </li>
            @foreach ($headerEventTypes as $eventtype)
            <li>
                <a href="{{ url('/?type=' . $eventtype->id) }}"
                    class="{{ (string) $currentType === (string) $eventtype->id ? 'active' : '' }}">
                    {{ $eventtype->event_type_name }} Tickets
                </a>
            </li>
            @endforeach
            <li class="header-event-types__more dropdown d-none" id="headerEventTypeMore">
                <button type="button"
                    class="header-event-types__more-btn dropdown-toggle"
                    id="headerEventTypeMoreBtn"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    More <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right header-event-types__dropdown" id="headerEventTypeMoreList" aria-labelledby="headerEventTypeMoreBtn"></div>
            </li>
        </ul>
    </div>
</div>

<script>
(function () {
    function layoutHeaderEventNav() {
        var nav = document.getElementById('headerEventTypeNav');
        var inner = nav ? nav.closest('.header-event-types__inner') : null;
        var moreLi = document.getElementById('headerEventTypeMore');
        var moreBtn = document.getElementById('headerEventTypeMoreBtn');
        var dropdownMenu = document.getElementById('headerEventTypeMoreList');

        if (!nav || !inner || !moreLi || !dropdownMenu || !moreBtn) {
            return;
        }

        if (typeof jQuery !== 'undefined') {
            jQuery(moreBtn).dropdown('hide');
        }

        var items = Array.prototype.slice.call(nav.querySelectorAll('li:not(.header-event-types__more)'));

        items.forEach(function (li) {
            li.classList.remove('d-none');
        });
        moreLi.classList.add('d-none');
        moreBtn.classList.remove('active');
        dropdownMenu.innerHTML = '';

        function fits() {
            return nav.scrollWidth <= inner.clientWidth;
        }

        if (fits()) {
            return;
        }

        moreLi.classList.remove('d-none');

        var hiddenItems = [];
        var i;

        for (i = items.length - 1; i >= 1; i--) {
            if (fits()) {
                break;
            }
            items[i].classList.add('d-none');
            hiddenItems.unshift(items[i]);
        }

        while (!fits() && hiddenItems.length < items.length - 1) {
            var nextIndex = items.length - 1 - hiddenItems.length;
            if (nextIndex <= 0) {
                break;
            }
            items[nextIndex].classList.add('d-none');
            hiddenItems.unshift(items[nextIndex]);
        }

        hiddenItems.forEach(function (li) {
            var link = li.querySelector('a');
            if (!link) {
                return;
            }

            var dropdownLink = document.createElement('a');
            dropdownLink.href = link.href;
            dropdownLink.textContent = link.textContent.trim();
            dropdownLink.className = 'dropdown-item' + (link.classList.contains('active') ? ' active' : '');

            if (link.classList.contains('active')) {
                moreBtn.classList.add('active');
            }

            dropdownMenu.appendChild(dropdownLink);
        });

        if (hiddenItems.length === 0) {
            moreLi.classList.add('d-none');
        }
    }

    var resizeTimer;
    function scheduleLayout() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(layoutHeaderEventNav, 100);
    }

    document.addEventListener('DOMContentLoaded', function () {
        layoutHeaderEventNav();

        if (typeof jQuery !== 'undefined') {
            jQuery('#headerEventTypeMore')
                .on('shown.bs.dropdown', function () {
                    document.getElementById('headerEventTypeMoreBtn').classList.add('is-open');
                })
                .on('hidden.bs.dropdown', function () {
                    document.getElementById('headerEventTypeMoreBtn').classList.remove('is-open');
                });
        }
    });

    window.addEventListener('resize', scheduleLayout);
    window.addEventListener('load', layoutHeaderEventNav);
})();
</script>

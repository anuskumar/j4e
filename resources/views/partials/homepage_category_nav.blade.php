@php
    $eventtypes = \App\Models\EventType::headerMenu()->select('event_type_name', 'id')->orderBy('event_type_name')->get();
    $currentType = request('type');
@endphp

<nav class="home-category-nav">
    <div class="container">
        <div class="home-category-nav__inner">
            <ul class="home-category-nav__list" id="homeCategoryNav">
                <li>
                    <a href="{{ url('/') }}" class="{{ empty($currentType) ? 'active' : '' }}">All Tickets</a>
                </li>
                @foreach ($eventtypes as $eventtype)
                <li>
                    <a href="{{ url('/?type=' . $eventtype->id) }}"
                        class="{{ (string) $currentType === (string) $eventtype->id ? 'active' : '' }}">
                        {{ $eventtype->event_type_name }} Tickets
                    </a>
                </li>
                @endforeach
                <li class="home-category-nav__more dropdown d-none" id="homeCategoryMore">
                    <button type="button"
                        class="home-category-nav__more-btn dropdown-toggle"
                        id="homeCategoryMoreBtn"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        More <i class="fas fa-chevron-down home-category-nav__chevron"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right home-category-dropdown" id="eventTypeMoreList" aria-labelledby="homeCategoryMoreBtn"></div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
(function () {
    function layoutCategoryNav() {
        var nav = document.getElementById('homeCategoryNav');
        var inner = nav ? nav.closest('.home-category-nav__inner') : null;
        var moreLi = document.getElementById('homeCategoryMore');
        var moreBtn = document.getElementById('homeCategoryMoreBtn');
        var dropdownMenu = document.getElementById('eventTypeMoreList');

        if (!nav || !inner || !moreLi || !dropdownMenu || !moreBtn) {
            return;
        }

        if (typeof jQuery !== 'undefined') {
            jQuery(moreBtn).dropdown('hide');
        }

        var items = Array.prototype.slice.call(nav.querySelectorAll('li:not(.home-category-nav__more)'));

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
        resizeTimer = setTimeout(layoutCategoryNav, 100);
    }

    document.addEventListener('DOMContentLoaded', function () {
        layoutCategoryNav();

        if (typeof jQuery !== 'undefined') {
            jQuery('#homeCategoryMore')
                .on('shown.bs.dropdown', function () {
                    document.getElementById('homeCategoryMoreBtn').classList.add('is-open');
                })
                .on('hidden.bs.dropdown', function () {
                    document.getElementById('homeCategoryMoreBtn').classList.remove('is-open');
                });
        }
    });

    window.addEventListener('resize', scheduleLayout);
    window.addEventListener('load', layoutCategoryNav);
})();
</script>

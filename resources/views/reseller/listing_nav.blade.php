<div class="card-header border-bottom">
    <ul class="nav nav-tabs card-header-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reseller.mylistings') ? 'active' : '' }}" 
               href="{{ route('reseller.mylistings') }}"
               style="{{ request()->routeIs('reseller.mylistings') ? 'background-color: #4dabf7; color: white; border-color: #4dabf7;' : '' }}">
                <i class="fe fe-list me-2"></i>My Listings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reseller.mysales') ? 'active' : '' }}" 
               href="{{ route('reseller.mysales') }}"
               style="{{ request()->routeIs('reseller.mysales') ? 'background-color: #4dabf7; color: white; border-color: #4dabf7;' : '' }}">
                <i class="fe fe-shopping-cart me-2"></i>My Sales
            </a>
        </li>
    </ul>
</div>

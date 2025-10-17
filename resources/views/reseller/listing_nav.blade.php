<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 0 auto;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link {{ request()->routeIs('reseller.mylistings') ? 'active' : '' }} " href="{{ route('reseller.mylistings') }}" ><b>My Listings</b></a>
      <a class="nav-item nav-link  {{ request()->routeIs('reseller.mysales') ? 'active' : '' }}" href="{{ route('reseller.mysales') }}"><b>My Sales</b></a>

    </div>
  </div>
</nav>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    body > nav,
    body > footer {
        flex-shrink: 0;
    }

    body > .reseller-page-content {
        flex: 1 0 auto;
    }

    .reseller-navbar {
        background: #7e0982;
        padding: 10px 0;
    }

    .reseller-navbar .navbar-brand,
    .reseller-navbar .navbar-brand strong,
    .reseller-navbar .navbar-brand span,
    .reseller-navbar .nav-link {
        color: #fff !important;
    }

    .reseller-navbar .nav-link:hover,
    .reseller-navbar .nav-link:focus {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    .reseller-navbar .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.6);
    }

    .reseller-navbar .navbar-toggler-icon {
        filter: invert(1);
    }

    .reseller-navbar .dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
</style>

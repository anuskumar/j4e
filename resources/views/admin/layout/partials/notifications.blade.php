<div class="dropdown nav-item main-header-notification">
    <a class="new nav-link position-relative" href="javascript:void(0);">
        <i class="fe fe-bell"></i>
        @if (($adminNotificationCount ?? 0) > 0)
            <span class="notification-count-badge">{{ ($adminNotificationCount ?? 0) > 99 ? '99+' : $adminNotificationCount }}</span>
        @else
            <span class="pulse"></span>
        @endif
    </a>
    <div class="dropdown-menu">
        <div class="menu-header-content bg-primary-gradient text-start d-flex">
            <div>
                <h6 class="menu-header-title text-white mb-0">
                    {{ $adminNotificationCount ?? 0 }} new {{ Str::plural('notification', $adminNotificationCount ?? 0) }}
                </h6>
            </div>
            @if (($adminNotificationCount ?? 0) > 0)
                <div class="my-auto ms-auto">
                    <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="badge bg-pill bg-warning border-0">Mark All Read</button>
                    </form>
                </div>
            @endif
        </div>
        <div class="main-notification-list Notification-scroll">
            @forelse ($adminNotifications ?? [] as $notification)
                <a class="d-flex p-3 border-bottom"
                    href="{{ $notification->source === 'notification' ? route('admin.notifications.open', $notification->id) : $notification->link }}">
                    <div class="notifyimg {{ $notification->icon_bg }}">
                        <i class="la {{ $notification->icon }}"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="notification-label mb-1">{{ $notification->title }}</h5>
                        @if (!empty($notification->message))
                            <p class="notification-subtext mb-1 text-muted tx-12">{{ Str::limit($notification->message, 80) }}</p>
                        @endif
                        <div class="notification-subtext">{{ $notification->time_ago }}</div>
                    </div>
                    <div class="ms-auto">
                        <i class="las la-angle-right text-end text-muted"></i>
                    </div>
                </a>
            @empty
                <div class="p-4 text-center text-muted">No new notifications</div>
            @endforelse
        </div>
        <div class="dropdown-footer">
            <a href="{{ route('admin.customer.neworder') }}">VIEW ORDERS</a>
        </div>
    </div>
</div>

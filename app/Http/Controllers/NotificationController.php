<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
    ) {
    }

    public function markAsRead(int $id): RedirectResponse
    {
        $this->notificationService->markAsRead($id, Auth::user());

        return back();
    }

    public function open(int $id): RedirectResponse
    {
        $link = $this->notificationService->openNotification($id, Auth::user());

        return redirect($link ?: route('admin.home'));
    }

    public function markAllAsRead(): RedirectResponse
    {
        $this->notificationService->markAllAsRead(Auth::user());

        return back();
    }

    public function count(Request $request)
    {
        return response()->json([
            'count' => $this->notificationService->getUnreadCount(Auth::user()),
        ]);
    }
}

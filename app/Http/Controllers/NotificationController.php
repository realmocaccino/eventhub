<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(
            auth()->user()->notifications
        );
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json($notification);
    }

    public function markAllAsRead()
    {
        if ($unreadNotifications = auth()->user()->unreadNotifications) {
            $unreadNotifications->markAsRead();
        }

        return response()->json($unreadNotifications);
    }
}
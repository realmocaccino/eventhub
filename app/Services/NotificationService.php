<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;

class NotificationService
{
    public function all(User $user): DatabaseNotificationCollection
    {
        return $user->notifications;
    }

    public function markAsRead(User $user, string $id): DatabaseNotification
    {
        $notification = $user->notifications
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return $notification;
    }

    public function markAllAsRead(User $user): DatabaseNotificationCollection
    {
        if ($unreadNotifications = $user->unreadNotifications) {
            $unreadNotifications->markAsRead();
        }

        return $unreadNotifications;
    }
}
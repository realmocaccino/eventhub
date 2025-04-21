<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function index()
    {
        return response()->json(
            $this->notificationService->all(
                auth()->user()
            )
        );
    }

    public function markAsRead($id)
    {
        return response()->json(
            $this->notificationService->markAsRead(
                auth()->user(),
                $id
            )
        );
    }

    public function markAllAsRead()
    {
        return response()->json(
            $this->notificationService->markAllAsRead(
                auth()->user()
            )
        );
    }
}
<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRegistrationRepositoryInterface;

class EloquentEventRegistrationRepository implements EventRegistrationRepositoryInterface
{
    public function __construct(
        protected Event $model
    ) {}

    public function findWithUsersCount(int $eventId): Event
    {
        return $this->model->withCount('users')->findOrFail($eventId);
    }

    public function isUserRegistered(int $eventId, int $userId): bool
    {
        return $this->model->findOrFail($eventId)
            ->users()
            ->where('user_id', $userId)
            ->exists();
    }

    public function registerUser(int $eventId, int $userId): void
    {
        $this->model->findOrFail($eventId)->users()->syncWithoutDetaching([$userId]);
    }

    public function unregisterUser(int $eventId, int $userId): void
    {
        $this->model->findOrFail($eventId)->users()->detach($userId);
    }
}
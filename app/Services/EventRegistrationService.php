<?php

namespace App\Services;

use App\Enums\RegistrationStatus;
use App\Exceptions\DuplicateRegistrationException;
use App\Exceptions\EventEndedException;
use App\Exceptions\EventFullException;
use App\Models\Event;
use App\Models\User;
use App\Notifications\RegistrationStatusChanged;
use App\Repositories\Interfaces\EventRegistrationRepositoryInterface;
use Carbon\Carbon;

class EventRegistrationService
{
    public function __construct(
        protected Carbon $now,
        protected EventRegistrationRepositoryInterface $repository
    ) {}

    public function isUserRegistered(Event $event, User $user): bool
    {
        return $this->repository->isUserRegistered($event->id, $user->id);
    }

    public function register(Event $event, User $user): void
    {
        $this->validateRegistration($event->id, $user->id);

        $this->repository->registerUser($event->id, $user->id);

        $user->notify(new RegistrationStatusChanged($event, RegistrationStatus::Registered));
    }

    private function validateRegistration(int $eventId, int $userId): void
    {
        $event = $this->repository->findWithUsersCount($eventId);

        if ($this->now->gt($event->ends_at)) {
            throw new EventEndedException();
        }

        if ($event->capacity !== null && $event->users_count >= $event->capacity) {
            throw new EventFullException();
        }

        if ($this->repository->isUserRegistered($event->id, $userId)) {
            throw new DuplicateRegistrationException();
        }
    }

    public function unregister(Event $event, User $user): void
    {
        $this->repository->unregisterUser($event->id, $user->id);

        $user->notify(new RegistrationStatusChanged($event, RegistrationStatus::Unregistered));
    }
}
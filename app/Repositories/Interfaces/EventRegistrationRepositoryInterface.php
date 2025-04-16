<?php

namespace App\Repositories\Interfaces;

interface EventRegistrationRepositoryInterface
{
    public function findWithUsersCount(int $eventId);
    public function isUserRegistered(int $eventId, int $userId): bool;
    public function registerUser(int $eventId, int $userId): void;
    public function unregisterUser(int $eventId, int $userId): void;
}
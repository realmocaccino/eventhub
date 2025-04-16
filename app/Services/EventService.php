<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    protected const DEFAULT_SORT_FIELD = 'starts_at';
    protected const DEFAULT_SORT_DIRECTION = 'desc';

    public function __construct(
        protected EventRepositoryInterface $eventRepository
    ) {}

    public function getAllEvents(?array $filters = [], ?string $sortField = null, ?string $sortDirection = null): LengthAwarePaginator
    {
        $sortField ??= self::DEFAULT_SORT_FIELD;
        $sortDirection ??= self::DEFAULT_SORT_DIRECTION;

        return $this->eventRepository->filterAndSort($filters, $sortField, $sortDirection);
    }

    public function getEventWithUsers(int $id): ?Event
    {
        return $this->eventRepository->find($id)->load('users');
    }

    public function createEvent(array $data, ?UploadedFile $image = null): Event
    {
        if ($image) {
            $data['image'] = $this->storeImage($image);
        }

        return $this->eventRepository->create($data);
    }

    public function updateEvent(int $id, array $data, ?UploadedFile $image = null): Event
    {
        if ($image) {
            $data['image'] = $this->storeImage($image);
        }

        if (array_key_exists('image', $data) && $data['image'] === null) {
            unset($data['image']);
        }

        return $this->eventRepository->update($id, $data);
    }

    public function deleteEvent(int $id): bool
    {
        return $this->eventRepository->delete($id);
    }

    private function storeImage(UploadedFile $image): string
    {
        return $image->store('events', 'public');
    }
}
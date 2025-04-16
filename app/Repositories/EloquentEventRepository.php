<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentEventRepository implements EventRepositoryInterface
{
    public function __construct(
        protected Event $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function find(int $id): ?Event
    {
        return $this->model->find($id);
    }

    public function withUsersCount(): Builder
    {
        return $this->model->withCount('users');
    }

    public function create(array $data): Event
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Event
    {
        $event = $this->model->findOrFail($id);
        $event->update($data);
        
        return $event;
    }

    public function delete(int $id): bool
    {
        $event = $this->model->findOrFail($id);

        return $event->delete();
    }

    public function filterAndSort(array $filters, string $sortField, string $sortDirection): LengthAwarePaginator
    {
        $query = $this->model->withCount('users');

        if (isset($filters['start_date'])) {
            $query->where('starts_at', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->where('ends_at', '<=', $filters['end_date']);
        }

        return $query->orderBy($sortField, $sortDirection)->paginate(10);
    }
}
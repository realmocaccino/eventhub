<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EventRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function find(int $id);
    public function withUsersCount();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
    public function filterAndSort(array $filters, string $sortField, string $sortDirection): LengthAwarePaginator;
}
<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function delete(int $id): bool;
    public function find(int $id);
    public function findByEmail(string $email);
    public function update(int $id, array $data);
}
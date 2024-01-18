<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClassesService
{
    public function listClasses(array $pagination): LengthAwarePaginator;

    public function fetchClass(int $id): array;

    public function createClass(array $data): array;

    public function updateClass(int $id, array $data): array;

    public function deleteClass(int $id, bool $force = false): array;

    public function restoreClass(int $id): array;
}

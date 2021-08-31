<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;
    public function count(): int;
    public function paginated(int $count): \Illuminate\Pagination\LengthAwarePaginator;
    public function create(array $attributes): Model;
    public function destroy(int $id): bool;
    public function find(int $id): ?Model;
    public function update(Model $model, array $attributes): Model;
}

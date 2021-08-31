<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->get();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->all()->count();
    }

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated(int $limit): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate($limit);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $model = $this->model->newInstance();
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param int $id
     */
    public function destroy(int $id): bool
    {
        return ($this->find($id)->delete());
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return ($this->model->find($id));
    }

    public function update(Model $model, array $attributes): Model
    {
        $model->update($attributes);

        return $model;
    }
}

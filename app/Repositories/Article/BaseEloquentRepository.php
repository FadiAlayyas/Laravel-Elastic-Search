<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\SearchableRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseEloquentRepository implements SearchableRepository
{
    /** @var Model */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function search(string $query): Collection
    {
        return $this->model->query()
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('body', 'LIKE', "%{$query}%")
            ->orWhereJsonContains('tags', $query)
            ->published() // Assuming a scope for published articles
            ->get();
    }
}

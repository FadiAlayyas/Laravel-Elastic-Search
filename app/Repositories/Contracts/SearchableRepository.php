<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface SearchableRepository
{
    public function search(string $query): Collection;
}

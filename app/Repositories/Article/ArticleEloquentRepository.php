<?php

namespace App\Repositories\Eloquent;

use App\Models\Article;

class ArticleEloquentRepository extends BaseEloquentRepository
{
    public function __construct()
    {
        parent::__construct(new Article());
    }
}

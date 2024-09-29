<?php

namespace App\Repositories\ElasticSearch;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\SearchableRepository;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class BaseElasticSearchRepository implements SearchableRepository
{
    /** @var \Elastic\Elasticsearch\Client */
    protected $elasticsearch;

    /** @var Model */
    protected $model;

    public function __construct(Client $elasticsearch, Model $model)
    {
        $this->elasticsearch = $elasticsearch;
        $this->model = $model;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $response = $this->elasticsearch->search([
            'index' => $this->model->getSearchIndex(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => $this->model->getElasticsearchFields(), // These fields can be customized
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $response['hits']['hits'] ?? [];
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items, '_id');
        return $this->model->findMany($ids)->sortBy($ids);
    }
}

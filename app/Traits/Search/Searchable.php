<?php

namespace App\Traits\Search;

use Elastic\Elasticsearch\Client;

trait Searchable
{
    public static function bootSearchable()
    {
        static::created(function ($model) {
            if (config('services.search.enabled', true)) {
                $model->elasticsearchIndex(app(Client::class));
            }
        });

        static::deleted(function ($model) {
            if (config('services.search.enabled', true)) {
                $model->elasticsearchDelete(app(Client::class));
            }
        });

        static::updated(function ($model) {
            if (config('services.search.enabled', true)) {
                $model->elasticsearchDelete(app(Client::class));
                $model->elasticsearchIndex(app(Client::class));
            }
        });
    }

    public function elasticsearchIndex(Client $elasticsearchClient)
    {
        $elasticsearchClient->index([
            'index' => $this->getSearchIndex(),
            'id' => $this->getKey(),
            'body' => $this->toElasticsearchDocumentArray(),
        ]);
    }

    public function elasticsearchDelete(Client $elasticsearchClient)
    {
        $elasticsearchClient->delete([
            'index' => $this->getSearchIndex(),
            'id' => $this->getKey(),
        ]);
    }

    /**
     * Get the name of the Elasticsearch index.
     *
     * @return string
     */
    public function getSearchIndex(): string
    {
        return $this->getTable(); // Default to the model's table name
    }

    abstract public function toElasticsearchDocumentArray(): array;
}

<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\Contracts\SearchableRepository;
use App\Repositories\ElasticSearch\BaseElasticSearchRepository;
use Elastic\Elasticsearch\Client;

class ArticleService
{
    protected $searchableRepository;

    public function __construct(SearchableRepository $searchableRepository = null)
    {
        $this->searchableRepository = $searchableRepository ?? new BaseElasticSearchRepository(app(Client::class), new Article());
    }

    /**
     * Get all articles, optionally using Elasticsearch for searching.
     *
     * @return array
     */
    public function getAllArticles(): array
    {
        if (request()->has('search_values')) {
            $articles = $this->searchableRepository->search(request('search_values'));
        } else {
            $articles = Article::with('author', 'category')->get();
        }

        return ['articles' => $articles];
    }

    /**
     * Get an article by its ID.
     *
     * @param int $id
     * @return Article
     */
    public function getById(int $id): Article
    {
        $article = Article::with('author', 'category')->findOrFail($id);
        return $article;
    }

    /**
     * Create a new article.
     *
     * @param array $data
     * @return Article
     */
    public function createArticle(array $data): Article
    {
        $article = Article::create($data);
        return $article->load('author', 'category');
    }

    /**
     * Update an existing article.
     *
     * @param Article $article
     * @param array $data
     * @return Article
     */
    public function updateArticle(Article $article, array $data): Article
    {
        $article->update($data);
        return $article->load('author', 'category');
    }

    /**
     * Delete an article.
     *
     * @param Article $article
     * @return void
     */
    public function deleteArticle(Article $article): void
    {
        $article->delete();
    }
}

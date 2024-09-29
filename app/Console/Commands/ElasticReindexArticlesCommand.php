<?php

namespace App\Console\Commands;

use App\Models\Article;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class ElasticReindexArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:articles-reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to Elasticsearch';

    /** @var \Elastic\Elasticsearch\Client */
    private $elasticsearch;

    /** @var Article */
    private $model;

    public function __construct(Client $elasticsearch, Article $article)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
        $this->model = $article;
    }

    public function handle()
    {
        $counter = 0;

        // Delete the existing index
        if ($this->elasticsearch->indices()->exists(['index' => $this->model->getSearchIndex()])) {
            $this->elasticsearch->indices()->delete(['index' => $this->model->getSearchIndex()]);
        }

        $this->info("\nArticle Count  : " . $this->model->count());
        $this->info('Indexing all articles. This might take a while...');

        foreach ($this->model->cursor() as $article) {
            $this->elasticsearch->index([
                'index' => $article->getSearchIndex(), // Get the index name
                'id' => $article->getKey(),            // Unique identifier for the document
                'body' => $article->toSearchArray(),   // Data to be indexed
            ]);

            $counter++;
            $this->info("Indexed article #{$counter} (ID: {$article->getKey()})");
        }

        $this->info("\nDone!");
    }
}

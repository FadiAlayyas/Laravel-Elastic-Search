<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ElasticReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to Elasticsearch';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('search:articles-reindex');

        $this->info('All data have been reindexed.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    // get List all articles use elastic search
    public function index()
    {
        $articles = $this->articleService->getAllArticles();
        return response()->json($articles);
    }

    // Show a specific article
    public function show($id)
    {
        $article = $this->articleService->getById($id);
        return response()->json($article);
    }

    // Create a new article
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'status' => 'required|in:draft,published,archived',
        ]);

        $article = $this->articleService->createArticle($validated);
        return response()->json($article, 201);
    }

    // Update an article
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes',
            'category_id' => 'sometimes|exists:categories,id',
            'tags' => 'array',
            'status' => 'sometimes|in:draft,published,archived',
        ]);

        $article = $this->articleService->updateArticle($article, $validated);
        return response()->json($article);
    }

    // Delete an article
    public function destroy(Article $article)
    {
        $this->articleService->deleteArticle($article);
        return response()->json(null, 204);
    }
}

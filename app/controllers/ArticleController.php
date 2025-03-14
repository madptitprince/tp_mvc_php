<?php
require_once __DIR__ . '/../models/Article.php';

class ArticleController {
    public function index() {
        $articles = Article::findAll();
        require_once __DIR__ . '/../views/article/index.php';
    }

    public function show($id) {
        $article = Article::findById($id);
        require_once __DIR__ . '/../views/article/show.php';
    }
}

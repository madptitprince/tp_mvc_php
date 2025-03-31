<?php
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../core/View.php';

class ArticleController {
    public function index() {
        $articles = Article::findAll();
        View::render('article/index', [
            'pageTitle' => 'Catalogue d\'articles',
            'articles' => $articles
        ]);
    }

    public function show($id) {
        $article = Article::findById($id);
        if (!$article) {
            View::setData('flashMessage', 'Article non trouvé');
            View::setData('flashMessageType', 'danger');
            $this->index();
            return;
        }
        View::render('article/show', [
            'pageTitle' => $article->nom,
            'article' => $article
        ]);
    }
}

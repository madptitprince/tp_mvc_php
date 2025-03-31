<div class="header-action-buttons">
    <h1>Catalogue des articles</h1>
    <div>
        <a href="/articles/create" class="btn btn-primary btn-icon">
            <i class="fas fa-plus"></i> Nouvel article
        </a>
    </div>
</div>

<div class="mb-4">
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un article...">
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($articles as $article): ?>
    <div class="col searchable-item">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($article->nom) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= number_format($article->prix, 2, ',', ' ') ?> €</h6>
                <p class="card-text"><?= strlen($article->description) > 100 ? substr(htmlspecialchars($article->description), 0, 100) . '...' : htmlspecialchars($article->description) ?></p>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <div class="d-flex justify-content-between">
                    <a href="/articles/show/<?= $article->id ?>" class="btn btn-sm btn-primary">Détails</a>
                    <div>
                        <a href="/articles/edit/<?= $article->id ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/articles/delete/<?= $article->id ?>" class="btn btn-sm btn-danger btn-delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= htmlspecialchars($article->nom) ?></h1>
    <div>
        <a href="/articles" class="btn btn-secondary btn-icon">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <a href="/articles/edit/<?= $article->id ?>" class="btn btn-warning btn-icon">
            <i class="fas fa-edit"></i> Modifier
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Détails de l'article</h5>
            </div>
            <div class="card-body">
                <h6 class="text-muted mb-3">Description</h6>
                <p><?= nl2br(htmlspecialchars($article->description)) ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Informations</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Prix:</th>
                        <td class="fw-bold fs-4"><?= number_format($article->prix, 2, ',', ' ') ?> €</td>
                    </tr>
                    <tr>
                        <th>ID:</th>
                        <td><?= $article->id ?></td>
                    </tr>
                </table>
                
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-success btn-lg">
                        <i class="fas fa-shopping-cart"></i> Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

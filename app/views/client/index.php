<div class="header-action-buttons">
    <h1>Liste des clients</h1>
    <a href="/clients/create" class="btn btn-primary btn-icon">
        <i class="fas fa-plus"></i> Nouveau client
    </a>
</div>

<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un client...">
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr class="searchable-item">
                <td><?= $client->id ?></td>
                <td><?= htmlspecialchars($client->nom) ?></td>
                <td><?= htmlspecialchars($client->email) ?></td>
                <td><?= htmlspecialchars($client->telephone) ?></td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="/clients/show/<?= $client->id ?>" class="btn btn-info" data-bs-toggle="tooltip" title="Voir détails">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/commandes/by-client/<?= $client->id ?>" class="btn btn-secondary" data-bs-toggle="tooltip" title="Commandes">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <a href="/clients/edit/<?= $client->id ?>" class="btn btn-warning" data-bs-toggle="tooltip" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/clients/delete/<?= $client->id ?>" class="btn btn-danger btn-delete" data-bs-toggle="tooltip" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="header-action-buttons">
    <h1>
        <?php if (isset($client)): ?>
            Commandes de <?= htmlspecialchars($client->nom) ?>
        <?php else: ?>
            Liste des commandes
        <?php endif; ?>
    </h1>
    
    <a href="/commandes/create" class="btn btn-primary btn-icon">
        <i class="fas fa-plus"></i> Nouvelle commande
    </a>
</div>

<?php if (isset($client)): ?>
    <div class="mb-3">
        <a href="/clients/show/<?= $client->id ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Retour au profil client
        </a>
    </div>
<?php endif; ?>

<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" id="searchInput" placeholder="Rechercher une commande...">
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
            <tr class="searchable-item">
                <td><?= $commande->id ?></td>
                <td>
                    <?php 
                    $client = Client::findById($commande->client_id);
                    echo $client ? htmlspecialchars($client->nom) : "Client #" . $commande->client_id;
                    ?>
                </td>
                <td><?= (new DateTime($commande->date_commande))->format('d/m/Y H:i') ?></td>
                                <td>
                                <?php
                                    $statusClass = "warning";
                                    
                                    echo '<span class="badge bg-' . $statusClass . '">' . $commande->statut . '</span>';
                                ?>
                                </td>
                                <td>
                                    <a href="/commandes/show/<?= $commande->id ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/commandes/edit/<?= $commande->id ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= htmlspecialchars($client->nom) ?></h1>
    <div>
        <a href="/clients" class="btn btn-secondary btn-icon">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <a href="/clients/edit/<?= $client->id ?>" class="btn btn-warning btn-icon">
            <i class="fas fa-edit"></i> Modifier
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0"><i class="fas fa-user-circle"></i> Informations du client</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">Email:</th>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($client->email) ?>">
                                <?= htmlspecialchars($client->email) ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Téléphone:</th>
                        <td>
                            <a href="tel:<?= htmlspecialchars($client->telephone) ?>">
                                <?= htmlspecialchars($client->telephone) ?>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0"><i class="fas fa-shopping-cart"></i> Commandes récentes</h5>
            </div>
            <div class="card-body">
                <?php 
                // This would require implementing a method to fetch the client's orders
                $commandes = Commande::findByClientId($client->id);
                
                if (!empty($commandes)): ?>
                    <div class="list-group">
                        <?php foreach(array_slice($commandes, 0, 5) as $commande): ?>
                            <a href="/commandes/show/<?= $commande->id ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Commande #<?= $commande->id ?></strong>
                                    <div class="text-muted"><?= $commande->date_commande ?></div>
                                </div>
                                <span class="badge bg-primary rounded-pill">Voir</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($commandes) > 5): ?>
                        <div class="text-center mt-3">
                            <a href="/commandes/by-client/<?= $client->id ?>" class="btn btn-sm btn-outline-secondary">Voir toutes les commandes</a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-muted">Ce client n'a pas encore passé de commande.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

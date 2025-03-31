<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Commande #<?= $commande->id ?></h1>
    <div>
        <a href="/commandes" class="btn btn-secondary btn-icon">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Client:</th>
                        <td>
                            <?php if ($client): ?>
                                <a href="/clients/show/<?= $client->id ?>">
                                    <?= htmlspecialchars($client->nom) ?>
                                </a>
                            <?php else: ?>
                                Client #<?= $commande->client_id ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td><?= (new DateTime($commande->date_commande))->format('d/m/Y H:i') ?></td>
                    </tr>
                    <tr>
                        <th>Statut:</th>
                        <td><span class="badge bg-warning"><?= htmlspecialchars($commande->statut) ?></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Articles commandés</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($items)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Article</th>
                                    <th class="text-center">Qté</th>
                                    <th class="text-end">Prix unitaire</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                foreach ($items as $item): 
                                    $itemTotal = $item->quantite * $item->prix_unitaire;
                                    $total += $itemTotal;
                                ?>
                                <tr>
                                    <td>
                                        <a href="/articles/show/<?= $item->article_id ?>">
                                            <?= htmlspecialchars($item->article_nom) ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?= $item->quantite ?></td>
                                    <td class="text-end"><?= number_format($item->prix_unitaire, 2, ',', ' ') ?> €</td>
                                    <td class="text-end"><?= number_format($itemTotal, 2, ',', ' ') ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end"><?= number_format($total, 2, ',', ' ') ?> €</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Cette commande ne contient aucun article.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

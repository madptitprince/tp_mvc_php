<h1>Liste des commandes</h1>
<?php
foreach ($commandes as $commande) {
    echo "<p>Commande #{$commande->id} du client {$commande->client_id} - {$commande->date_commande}</p>";
}

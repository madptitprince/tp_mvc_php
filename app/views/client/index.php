<?php foreach ($clients as $client) {
    echo "<p>{$client->getNom()} - {$client->getEmail()}</p>";
}

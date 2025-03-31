<?php
// This file displays active sessions
?>

<h1>Active Sessions</h1>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Session ID</th>
                <th>Client</th>
                <th>Created</th>
                <th>Expires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sessions as $session): ?>
            <tr>
                <td><code><?= htmlspecialchars(substr($session['id'], 0, 16)) ?>...</code></td>
                <td>
                    <?php if ($session['client_id']): ?>
                        <a href="/clients/show/<?= $session['client_id'] ?>">
                            <?= htmlspecialchars($session['client_name']) ?> 
                            <small>(<?= htmlspecialchars($session['client_email']) ?>)</small>
                        </a>
                    <?php else: ?>
                        <span class="text-muted">Anonymous</span>
                    <?php endif; ?>
                </td>
                <td><?= (new DateTime($session['created_at']))->format('Y-m-d H:i:s') ?></td>
                <td><?= (new DateTime($session['expires_at']))->format('Y-m-d H:i:s') ?></td>
                <td>
                    <a href="/sessions/destroy/<?= $session['id'] ?>" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Terminate
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Gestion de Commandes' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary shadow">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Système de Gestion</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/clients"><i class="fas fa-users"></i> Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/commandes"><i class="fas fa-shopping-cart"></i> Commandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/articles"><i class="fas fa-box"></i> Articles</a>
                        </li>
                    </ul>
                    <div class="navbar-nav">
                        <?php if (isset($_COOKIE['session_id'])): ?>
                            <a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                        <?php else: ?>
                            <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                            <a class="nav-link" href="/register"><i class="fas fa-user-plus"></i> Inscription</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        <?php if (isset($flashMessage)): ?>
            <div class="alert alert-<?= $flashMessageType ?? 'info' ?> alert-dismissible fade show">
                <?= $flashMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <footer class="bg-dark text-white py-3 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">Système de Gestion MVC</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; <?= date('Y') ?> - Tous droits réservés</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="/assets/js/main.js"></script>
</body>
</html>
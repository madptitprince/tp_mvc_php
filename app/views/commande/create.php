<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nouvelle Commande</h1>
    <div>
        <a href="/commandes" class="btn btn-secondary btn-icon">
            <i class="fas fa-arrow-left"></i> Retour aux commandes
        </a>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" class="needs-validation" novalidate>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Sélectionner des articles</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un article...">
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>Article</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                        <tr class="searchable-item">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input article-checkbox" type="checkbox" 
                                           name="article_ids[]" value="<?= $article->id ?>" 
                                           id="article<?= $article->id ?>">
                                </div>
                            </td>
                            <td>
                                <label for="article<?= $article->id ?>" class="fw-bold"><?= htmlspecialchars($article->nom) ?></label>
                                <div class="text-muted small"><?= substr(htmlspecialchars($article->description), 0, 100) ?>...</div>
                            </td>
                            <td class="text-nowrap"><?= number_format($article->prix, 2, ',', ' ') ?> €</td>
                            <td style="width: 120px;">
                                <input type="number" class="form-control form-control-sm quantity-input" 
                                       name="quantities[]" value="0" min="0" disabled
                                       data-price="<?= $article->prix ?>">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <div>
                <span class="fw-bold">Total:</span>
                <span id="orderTotal" class="fs-5 ms-2">0,00 €</span>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Commander
            </button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        document.querySelectorAll('.searchable-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
    
    // Handle checkboxes
    document.querySelectorAll('.article-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const row = this.closest('tr');
            const quantityInput = row.querySelector('.quantity-input');
            
            if (this.checked) {
                quantityInput.disabled = false;
                quantityInput.value = 1;
            } else {
                quantityInput.disabled = true;
                quantityInput.value = 0;
            }
            
            updateTotal();
        });
    });
    
    // Handle quantity changes
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            if (parseInt(this.value) > 0) {
                this.closest('tr').querySelector('.article-checkbox').checked = true;
            } else {
                this.closest('tr').querySelector('.article-checkbox').checked = false;
                this.disabled = true;
                this.value = 0;
            }
            
            updateTotal();
        });
    });
    
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            if (!input.disabled && input.value > 0) {
                total += parseFloat(input.dataset.price) * parseInt(input.value);
            }
        });
        
        document.getElementById('orderTotal').textContent = total.toLocaleString('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' €';
    }
});
</script>
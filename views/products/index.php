<?php
$content = ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Product Management</h1>
        <p class="text-muted">Manage your product inventory efficiently</p>
    </div>
    <a href="/products/create" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Add New Product
    </a>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/products" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search products..." 
                       value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="category" class="form-control" placeholder="Filter by category..." 
                       value="<?= htmlspecialchars($category ?? '') ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-search me-1"></i>Search
                </button>
            </div>
            <div class="col-md-3">
                <a href="/products" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-refresh me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<?php if (empty($products)): ?>
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="card-title">No products found</h5>
            <p class="card-text">Get started by adding your first product to the inventory.</p>
            <a href="/products/create" class="btn btn-primary">Add Product</a>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Products (<?= $total ?>)</h5>
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <span class="text-muted">Page <?= $page ?> of <?= $totalPages ?></span>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><strong>#<?= $product->id ?></strong></td>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($product->name) ?></div>
                            <small class="text-muted"><?= htmlspecialchars(substr($product->description, 0, 50)) ?>...</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= htmlspecialchars($product->category) ?></span>
                        </td>
                        <td class="fw-bold text-success">$<?= number_format($product->price, 2) ?></td>
                        <td>
                            <span class="badge <?= $product->quantity > 10 ? 'bg-success' : ($product->quantity > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                <?= $product->quantity ?> in stock
                            </span>
                        </td>
                        <td>
                            <small class="text-muted"><?= date('M j, Y', strtotime($product->created_at)) ?></small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="/products/<?= $product->id ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/products/<?= $product->id ?>/edit" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="/products/<?= $product->id ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="card-footer bg-white">
            <nav>
                <ul class="pagination justify-content-center mb-0">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>&category=<?= urlencode($category ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
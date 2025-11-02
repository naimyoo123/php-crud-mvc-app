<?php
$content = ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Product Details</h5>
                <div>
                    <a href="/products/<?= $product->id ?>/edit" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="/products/<?= $product->id ?>" method="POST" class="d-inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!-- Product Header -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h2 class="h4 text-primary"><?= htmlspecialchars($product->name) ?></h2>
                        <p class="text-muted mb-2">Product ID: #<?= $product->id ?></p>
                        <span class="badge bg-secondary fs-6"><?= htmlspecialchars($product->category) ?></span>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <h3 class="h2 text-success mb-1">$<?= number_format($product->price, 2) ?></h3>
                        <div class="d-flex align-items-center justify-content-md-end">
                            <span class="badge <?= $product->quantity > 10 ? 'bg-success' : ($product->quantity > 0 ? 'bg-warning' : 'bg-danger') ?> fs-6 me-2">
                                <?= $product->quantity ?> in stock
                            </span>
                            <?php if ($product->quantity == 0): ?>
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Out of Stock</span>
                            <?php elseif ($product->quantity <= 5): ?>
                                <span class="text-warning"><i class="fas fa-exclamation-circle"></i> Low Stock</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Description</h5>
                        <p class="lead"><?= nl2br(htmlspecialchars($product->description)) ?></p>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Product Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" width="40%"><strong>Product ID:</strong></td>
                                        <td>#<?= $product->id ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><strong>Category:</strong></td>
                                        <td>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($product->category) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><strong>Unit Price:</strong></td>
                                        <td class="fw-bold text-success">$<?= number_format($product->price, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><strong>Current Stock:</strong></td>
                                        <td>
                                            <span class="fw-bold <?= $product->quantity > 10 ? 'text-success' : ($product->quantity > 0 ? 'text-warning' : 'text-danger') ?>">
                                                <?= $product->quantity ?> units
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><strong>Stock Value:</strong></td>
                                        <td class="fw-bold text-primary">
                                            $<?= number_format($product->price * $product->quantity, 2) ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-history me-2"></i>Timeline</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" width="40%"><strong>Created:</strong></td>
                                        <td>
                                            <i class="fas fa-calendar-plus text-muted me-1"></i>
                                            <?= date('F j, Y', strtotime($product->created_at)) ?>
                                            <br>
                                            <small class="text-muted">
                                                at <?= date('g:i A', strtotime($product->created_at)) ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><strong>Last Updated:</strong></td>
                                        <td>
                                            <i class="fas fa-calendar-check text-muted me-1"></i>
                                            <?= date('F j, Y', strtotime($product->updated_at)) ?>
                                            <br>
                                            <small class="text-muted">
                                                at <?= date('g:i A', strtotime($product->updated_at)) ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><strong>Time in System:</strong></td>
                                        <td>
                                            <?php
                                            $created = new DateTime($product->created_at);
                                            $now = new DateTime();
                                            $interval = $created->diff($now);
                                            
                                            if ($interval->y > 0) {
                                                echo $interval->y . ' year' . ($interval->y > 1 ? 's' : '');
                                            } elseif ($interval->m > 0) {
                                                echo $interval->m . ' month' . ($interval->m > 1 ? 's' : '');
                                            } elseif ($interval->d > 0) {
                                                echo $interval->d . ' day' . ($interval->d > 1 ? 's' : '');
                                            } else {
                                                echo 'Less than a day';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Alert -->
                <?php if ($product->quantity == 0): ?>
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Out of Stock</h6>
                            This product is currently out of stock. Consider restocking or updating inventory.
                        </div>
                    </div>
                <?php elseif ($product->quantity <= 5): ?>
                    <div class="alert alert-warning d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Low Stock Alert</h6>
                            This product is running low. Current stock: <?= $product->quantity ?> units.
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="/products" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Products
                    </a>
                    <div>
                        <a href="/products/<?= $product->id ?>/edit" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i>Edit Product
                        </a>
                        <form action="/products/<?= $product->id ?>" method="POST" class="d-inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete \"<?= htmlspecialchars($product->name) ?>\"? This action cannot be undone.')">
                                <i class="fas fa-trash me-1"></i>Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Card -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Quick Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-muted mb-1">Unit Price</h6>
                            <p class="mb-0 h5 text-success">$<?= number_format($product->price, 2) ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-muted mb-1">Available Stock</h6>
                            <p class="mb-0 h5 <?= $product->quantity > 10 ? 'text-success' : ($product->quantity > 0 ? 'text-warning' : 'text-danger') ?>">
                                <?= $product->quantity ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-muted mb-1">Total Value</h6>
                            <p class="mb-0 h5 text-primary">$<?= number_format($product->price * $product->quantity, 2) ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-muted mb-1">Status</h6>
                            <p class="mb-0">
                                <span class="badge <?= $product->quantity > 10 ? 'bg-success' : ($product->quantity > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                    <?= $product->quantity > 10 ? 'Well Stocked' : ($product->quantity > 0 ? 'Needs Attention' : 'Out of Stock') ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
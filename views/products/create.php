<?php
$content = ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Product</h5>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($_SESSION['errors'] as $field => $fieldErrors): ?>
                                <?php foreach ($fieldErrors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                <form method="POST" action="/products">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>" required>
                        <?php unset($_SESSION['old']['name']); ?>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($_SESSION['old']['description'] ?? '') ?></textarea>
                        <?php unset($_SESSION['old']['description']); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" 
                                       value="<?= htmlspecialchars($_SESSION['old']['price'] ?? '') ?>" required>
                                <?php unset($_SESSION['old']['price']); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control" id="quantity" name="quantity" 
                                       value="<?= htmlspecialchars($_SESSION['old']['quantity'] ?? '') ?>" required>
                                <?php unset($_SESSION['old']['quantity']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category" name="category" 
                               value="<?= htmlspecialchars($_SESSION['old']['category'] ?? '') ?>" required>
                        <?php unset($_SESSION['old']['category']); ?>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="/products" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
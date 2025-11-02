<?php
$content = ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <div class="card">
            <div class="card-body py-5">
                <i class="fas fa-exclamation-triangle fa-5x text-warning mb-4"></i>
                <h1 class="display-4 text-muted">404</h1>
                <h3 class="mb-4">Page Not Found</h3>
                <p class="text-muted mb-4">
                    The page you are looking for might have been removed, had its name changed, 
                    or is temporarily unavailable.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="/products" class="btn btn-primary me-md-2">
                        <i class="fas fa-home me-1"></i>Go to Products
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
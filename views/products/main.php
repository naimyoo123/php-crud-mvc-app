<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Modern PHP CRUD' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand { 
            font-weight: 700; 
            font-size: 1.5rem;
        }
        .card { 
            border: none; 
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }
        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        .table th { 
            border-top: none; 
            font-weight: 600;
            background-color: #f8f9fa;
        }
        .badge { 
            font-size: 0.75em; 
            font-weight: 500;
        }
        .action-buttons .btn { 
            margin-right: 0.25rem; 
        }
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .feature-icon i {
            font-size: 1.5rem;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-boxes me-2"></i>Modern CRUD
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/products') !== false && $_SERVER['REQUEST_URI'] !== '/products/create' ? 'active' : '' ?>" 
                           href="/products">
                            <i class="fas fa-list me-1"></i>All Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/products/create' ? 'active' : '' ?>" 
                           href="/products/create">
                            <i class="fas fa-plus me-1"></i>Add Product
                        </a>
                    </li>
                </ul>
                <form method="GET" action="/products" class="d-flex">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search products..." 
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2 fa-lg"></i>
                <div class="flex-grow-1">
                    <?= $_SESSION['success'] ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2 fa-lg"></i>
                <div class="flex-grow-1">
                    <?= $_SESSION['error'] ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Modern PHP CRUD</h5>
                    <p class="text-muted mb-0">
                        A demonstration of modern PHP development practices with custom MVC framework.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="mb-3">Built With</h6>
                    <div class="d-flex justify-content-md-end gap-3">
                        <span class="badge bg-primary">PHP 8+</span>
                        <span class="badge bg-success">Custom MVC</span>
                        <span class="badge bg-info">Bootstrap 5</span>
                        <span class="badge bg-warning">MySQL</span>
                    </div>
                </div>
            </div>
            <hr class="my-3 bg-secondary">
            <div class="text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> Modern PHP CRUD Application</p>
                <small class="text-muted">Built with custom MVC framework for portfolio demonstration</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                if (alert.classList.contains('show')) {
                    new bootstrap.Alert(alert).close();
                }
            });
        }, 5000);

        // Add confirmation for all delete forms
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[method="POST"] input[name="_method"][value="DELETE"]').forEach(input => {
                const form = input.closest('form');
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
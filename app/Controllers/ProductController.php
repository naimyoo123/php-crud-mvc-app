<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';

        if ($search) {
            $products = $this->productRepository->search($search, $category);
            $data = [
                'products' => $products,
                'total' => count($products),
                'page' => 1,
                'totalPages' => 1,
                'search' => $search,
                'category' => $category
            ];
        } else {
            $data = $this->productRepository->findAll($page);
        }

        $this->view('products.index', $data);
    }

    public function create()
    {
        $this->view('products.create');
    }

    public function store()
    {
        $errors = $this->validate($_POST, [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category' => 'required|min:2|max:100'
        ]);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirect('/products/create');
        }

        $product = new Product($_POST);
        
        if ($this->productRepository->save($product)) {
            $_SESSION['success'] = 'Product created successfully!';
            $this->redirect('/products');
        } else {
            $_SESSION['error'] = 'Failed to create product.';
            $this->redirect('/products/create');
        }
    }

    public function show($id)
    {
        $product = $this->productRepository->findById($id);
        
        if (!$product) {
            $this->view('errors.404');
            return;
        }

        $this->view('products.show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = $this->productRepository->findById($id);
        
        if (!$product) {
            $this->view('errors.404');
            return;
        }

        $this->view('products.edit', ['product' => $product]);
    }

    public function update($id)
    {
        $product = $this->productRepository->findById($id);
        
        if (!$product) {
            $this->view('errors.404');
            return;
        }

        $errors = $this->validate($_POST, [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category' => 'required|min:2|max:100'
        ]);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect("/products/{$id}/edit");
        }

        // Update product properties
        $product->name = $_POST['name'];
        $product->description = $_POST['description'];
        $product->price = $_POST['price'];
        $product->quantity = $_POST['quantity'];
        $product->category = $_POST['category'];

        if ($this->productRepository->save($product)) {
            $_SESSION['success'] = 'Product updated successfully!';
            $this->redirect('/products');
        } else {
            $_SESSION['error'] = 'Failed to update product.';
            $this->redirect("/products/{$id}/edit");
        }
    }

    public function destroy($id)
    {
        if ($this->productRepository->delete($id)) {
            $_SESSION['success'] = 'Product deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete product.';
        }

        $this->redirect('/products');
    }
}
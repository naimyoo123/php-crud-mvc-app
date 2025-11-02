<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Product;
use PDO;

class ProductRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        
        $stmt = $this->db->prepare("
            SELECT * FROM products 
            ORDER BY created_at DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = new Product($row);
        }

        // Get total count for pagination
        $total = $this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();

        return [
            'products' => $products,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'totalPages' => ceil($total / $limit)
        ];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        return $data ? new Product($data) : null;
    }

    public function save(Product $product)
    {
        if ($product->id) {
            return $this->update($product);
        } else {
            return $this->create($product);
        }
    }

    public function create(Product $product)
    {
        $sql = "INSERT INTO products (name, description, price, quantity, category) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            $product->name,
            $product->description,
            $product->price,
            $product->quantity,
            $product->category
        ]);

        if ($success) {
            $product->id = $this->db->lastInsertId();
        }

        return $success;
    }

    public function update(Product $product)
    {
        $sql = "UPDATE products 
                SET name = ?, description = ?, price = ?, quantity = ?, category = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $product->name,
            $product->description,
            $product->price,
            $product->quantity,
            $product->category,
            $product->id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function search($term, $category = null)
    {
        $sql = "SELECT * FROM products 
                WHERE (name LIKE ? OR description LIKE ?)";
        $params = ["%$term%", "%$term%"];

        if ($category) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = new Product($row);
        }

        return $products;
    }
}
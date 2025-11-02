<?php

namespace App\Models;

class Product
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $quantity;
    public $category;
    public $created_at;
    public $updated_at;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
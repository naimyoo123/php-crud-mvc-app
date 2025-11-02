# Modern PHP CRUD Application

A simple **PHP MVC CRUD application** to manage products. Built with **plain PHP** using a modern MVC architecture, Composer for dependency management, and dotenv for environment configuration.

---

## Features

- Follows MVC architecture pattern for clean separation of concerns  
- Full CRUD operations (Create, Read, Update, Delete) for products  
- Secure database connection using PDO  
- Environment configuration via `.env` file for easy setup  
- Modular, extendable codebase for easy maintenance and enhancement  

---

## Project Structure

modern-php-crud/
├── app/
│   ├── Core/         # Core system files (Router, Database, Controller)
│   ├── Controllers/  # Application controllers
│   ├── Models/       # Database models
│   └── Repositories/ # Data access and query logic
├── config/           # Configuration files (e.g., database.php)
├── public/           # Public assets and entry point (index.php)
│   └── assets/       # CSS, JS, images
├── views/            # Application views and templates
├── vendor/           # Composer dependencies (ignored in repo)
└── .env.example      # Sample environment configuration file



---

## Requirements

- PHP 8 or higher  
- Composer  
- MySQL database  

---
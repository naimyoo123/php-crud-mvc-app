# MVC PHP CRUD

A simple **PHP MVC CRUD application** for managing products.  
Built with **plain PHP** using a modern MVC structure, Composer, and dotenv for configuration.

## Features

- MVC architecture
- CRUD operations (Create, Read, Update, Delete) for products
- Database connection via PDO
- Environment configuration with `.env`
- Modular and extendable

## Project Structure

app/
├── Core/ # Core system files (Router, Database, Controller)
├── Controllers/ # Application controllers
├── Models/ # Database models
└── Repositories/ # Database query logic

config/ # Configuration files (database.php)
public/ # Public assets and entry point (index.php)
views/ # Application views (HTML templates)
vendor/ # Composer dependencies (ignored in repo)
.env.example # Sample environment variables

## Requirements

- PHP 8+
- Composer
- MySQL or MariaDB

## Installation

1. Clone the repository:

```bash
git clone https://github.com/YOUR_USERNAME/mvc-php-crud.git
cd mvc-php-crud

# 🚀 Rapid Store Backend - Dokumentasi Lengkap

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?logo=mysql)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Dokumentasi teknis lengkap untuk Rapid Store Backend - sistem game top-up berbasis Laravel dan MySQL.

---

## 📑 Daftar Isi

### 🎯 Quick Start
- [Overview](#-overview)
- [Tech Stack](#-tech-stack)
- [Setup Awal (5 Menit)](#-setup-awal-5-menit)
- [Perintah Artisan Penting](#-perintah-artisan-paling-sering-digunakan)

### 📦 Instalasi & Konfigurasi
- [Prerequisites](#-prerequisites)
- [Instalasi Lokal](#-instalasi-lokal-windows-macos-linux)
- [Instalasi Docker](#-instalasi-docker)
- [Konfigurasi Environment](#-konfigurasi-environment-file)
- [Setup Database](#-setup-database)

### 🏗️ Arsitektur & Struktur
- [Arsitektur Sistem](#-arsitektur--alur-logic-sistem)
- [Struktur Folder](#-struktur-folder-proyek)
- [Layer Explanation](#-layer-by-layer-explanation)

### 📡 API & Database
- [API Documentation](#-api-documentation)
- [Database Schema](#-database-schema)
- [Endpoints Reference](#-endpoints-lengkap)

### 💻 Development
- [Membuat Feature Baru](#-membuat-feature-baru)
- [Database Queries Tips](#-database-query-tips)
- [Testing](#-testing)
- [Debugging](#-debugging)

### 📚 Guidelines
- [Coding Standards](#-coding-standards)
- [Git Workflow](#-git-workflow)
- [Contributing Guide](#-contributing-guidelines)

### 🔍 Reference
- [Troubleshooting](#-troubleshooting)
- [Useful Links](#-useful-links)

---

## 🎯 Overview

**Rapid Store** adalah platform backend untuk transaksi game top-up yang dirancang dengan prinsip arsitektur modern. Sistem ini menyediakan:

- ✅ RESTful API untuk manajemen produk game
- ✅ Sistem pembayaran terintegrasi
- ✅ Database terstruktur dengan MySQL
- ✅ Authentication & Authorization dengan Sanctum
- ✅ Error handling yang robust
- ✅ Logging dan monitoring
- ✅ Caching & optimization
- ✅ Testing comprehensive

---

## ⚙️ Tech Stack

| Komponen | Teknologi | Versi |
|----------|-----------|-------|
| **Framework** | Laravel | 11.x |
| **Language** | PHP | 8.2+ |
| **Database** | MySQL | 8.0+ |
| **ORM** | Eloquent | Built-in |
| **Authentication** | Laravel Sanctum | Built-in |
| **Testing** | PHPUnit | Built-in |
| **Queue** | Redis/Database | Optional |

---

## ⚡ Setup Awal (5 Menit)

```bash
# 1. Clone repository
git clone https://github.com/yourname/rapid-store.git
cd rapid-store

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Setup database
# Pastikan MySQL running, edit .env DB_* variables jika perlu
php artisan migrate
php artisan db:seed

# 5. Start server
php artisan serve
# Server berjalan di: http://localhost:8000
```

---

## 🔧 Perintah Artisan Paling Sering Digunakan

```bash
# Server
php artisan serve                      # Start dev server di port 8000

# Database
php artisan migrate                    # Run all migrations
php artisan migrate:rollback           # Rollback last migration
php artisan migrate:refresh            # Refresh database (HATI-HATI!)
php artisan db:seed                    # Run seeders

# Model & Scaffold
php artisan make:model Product -m      # Create model + migration
php artisan make:controller Api/ProductController --resource
php artisan make:request StoreProductRequest
php artisan make:seeder ProductSeeder

# Cache & Config
php artisan cache:clear               # Clear cache
php artisan config:clear              # Clear config cache
php artisan view:clear                # Clear view cache
php artisan route:clear               # Clear route cache

# Testing
php artisan test                       # Run all tests
php artisan test --filter testName     # Run specific test
php artisan test --coverage            # With coverage report
```

---

## ✅ Prerequisites

### Software Wajib

| Software | Versi | Check |
|----------|-------|-------|
| **PHP** | 8.2+ | `php -v` |
| **Composer** | 2.0+ | `composer --version` |
| **MySQL** | 8.0+ | `mysql --version` |
| **Git** | Latest | `git --version` |

### Software Opsional

- **Node.js** (v16+) - Untuk build tools
- **Redis** - Untuk caching & queue
- **Docker** - Untuk containerization

---

## 🖥️ Instalasi Lokal (Windows, macOS, Linux)

### Step 1: Clone Repository

```bash
git clone https://github.com/yourname/rapid-store.git
cd rapid-store
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Setup Environment File

```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rapid_store
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Create Database

```bash
# Login ke MySQL
mysql -u root -p

# Di dalam MySQL prompt:
CREATE DATABASE rapid_store;
CREATE DATABASE rapid_store_test;
EXIT;
```

### Step 6: Run Migrations & Seeding

```bash
# Jalankan semua migration
php artisan migrate

# Jalankan seeder untuk data dummy
php artisan db:seed

# Atau specific seeder
php artisan db:seed --class=UserSeeder
```

### Step 7: Generate Storage Symlink

```bash
php artisan storage:link
```

### Step 8: Start Development Server

```bash
php artisan serve
# Server berjalan di http://localhost:8000
```

---

## 🐳 Instalasi Docker

### Step 1: Setup docker-compose.yml

```yaml
version: '3.8'

services:
  mysql:
    image: mysql:8.0
    container_name: rapid_store_mysql
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: rapid_store
      MYSQL_USER: laravel
      MYSQL_PASSWORD: secret
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - rapid-store-network
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      interval: 10s
      timeout: 5s
      retries: 5

  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: rapid_store_app
    working_dir: /var/www/html
    environment:
      DB_HOST: mysql
      DB_PORT: 3306
      DB_DATABASE: rapid_store
      DB_USERNAME: laravel
      DB_PASSWORD: secret
    ports:
      - "8000:8000"
    depends_on:
      mysql:
        condition: service_healthy
    volumes:
      - ./:/var/www/html
    networks:
      - rapid-store-network
    command: php artisan serve --host=0.0.0.0 --port=8000

  redis:
    image: redis:7-alpine
    container_name: rapid_store_redis
    ports:
      - "6379:6379"
    networks:
      - rapid-store-network

volumes:
  mysql_data:
    driver: local

networks:
  rapid-store-network:
    driver: bridge
```

### Step 2: Setup Dockerfile

```dockerfile
FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html
RUN composer install

RUN chown -R www-data:www-data /var/www/html

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

### Step 3: Build & Run

```bash
# Build images
docker-compose build

# Start containers
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

# Stop containers
docker-compose down
```

---

## 🔧 Konfigurasi Environment File

### Template .env.example

```env
# APPLICATION
APP_NAME="Rapid Store"
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta

# DATABASE
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rapid_store
DB_USERNAME=root
DB_PASSWORD=
DB_COLLATION=utf8mb4_unicode_ci
DB_CHARSET=utf8mb4

# TEST DATABASE
DB_TEST_DATABASE=rapid_store_test

# CACHE & SESSION
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# QUEUE
QUEUE_CONNECTION=sync

# REDIS (optional)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# MAIL
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@rapidstore.com
MAIL_FROM_NAME="Rapid Store"

# SANCTUM
SANCTUM_STATEFUL_DOMAINS=localhost:3000,localhost:8000
SANCTUM_TOKENS_EXPIRATION=525600

# LOGGING
LOG_CHANNEL=stack
LOG_LEVEL=debug

# API
API_PREFIX=api
API_VERSION=v1
```

---

## 🗄️ Setup Database

### Manual MySQL Setup

```sql
-- Create databases
CREATE DATABASE rapid_store 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

CREATE DATABASE rapid_store_test 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'rapid_store'@'localhost' IDENTIFIED BY 'strong_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON rapid_store.* TO 'rapid_store'@'localhost';
GRANT ALL PRIVILEGES ON rapid_store_test.* TO 'rapid_store'@'localhost';

FLUSH PRIVILEGES;
```

### Test Connection

```bash
php artisan tinker
# Di dalam tinker:
>>> DB::connection()->getPDO()
# Jika berhasil, akan return PDO object
```

---

## 🏗️ Arsitektur & Alur Logic Sistem

### Konsep Separation of Concerns

```
Request (User/Client)
    ↓
    ├─→ Route (Endpoint Definition)
    ├─→ Controller (Request Handler)
    ├─→ Request Validation
    ├─→ Service Layer (Business Logic)
    ├─→ Repository Layer (Data Access)
    ├─→ Model (Database Interaction)
    └─→ Response (JSON/View)
```

### Two-Way Communication

```
┌─────────────────────┐                    ┌──────────────────────┐
│  APK Flutter (HP)   │                    │   ESP32 Robot (AGV)  │
│  Control Tower      │◄───Telemetri────► │   Microcontroller    │
│                     │                    │                      │
│  - Mission Dispatch │───Perintah────────►│  - Line Tracking     │
│  - Telemetry View   │◄───Data Sensor─────│  - Obstacle Avoidance│
│  - Emergency Stop   │                    │  - Motor Control     │
└─────────────────────┘                    └──────────────────────┘
```

---

## 📁 Struktur Folder Proyek

```
rapid-store/
├── app/
│   ├── Console/
│   │   └── Commands/                  # Custom artisan commands
│   │
│   ├── Exceptions/
│   │   ├── Handler.php               # Exception handler
│   │   ├── GameProductNotFoundException.php
│   │   └── InvalidOrderException.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── GameProductController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   └── UserController.php
│   │   │   └── Web/
│   │   │       ├── DashboardController.php
│   │   │       └── ProductController.php
│   │   │
│   │   ├── Requests/
│   │   │   ├── Api/
│   │   │   │   ├── StoreGameProductRequest.php
│   │   │   │   └── UpdateGameProductRequest.php
│   │   │   └── Web/
│   │   │       └── ProfileUpdateRequest.php
│   │   │
│   │   ├── Resources/
│   │   │   ├── GameProductResource.php
│   │   │   ├── CategoryResource.php
│   │   │   └── OrderResource.php
│   │   │
│   │   └── Middleware/
│   │       ├── Authenticate.php
│   │       ├── RoleCheck.php
│   │       └── ApiKeyValidation.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── GameProduct.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   └── Payment.php
│   │
│   ├── Services/
│   │   ├── GameProductService.php
│   │   ├── OrderService.php
│   │   ├── PaymentService.php
│   │   └── NotificationService.php
│   │
│   ├── Repositories/
│   │   ├── Interfaces/
│   │   │   ├── GameProductRepositoryInterface.php
│   │   │   └── OrderRepositoryInterface.php
│   │   ├── GameProductRepository.php
│   │   └── OrderRepository.php
│   │
│   ├── Traits/
│   │   ├── ApiResponse.php
│   │   └── ErrorHandler.php
│   │
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       └── RepositoryServiceProvider.php
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_xx_xx_create_users_table.php
│   │   ├── xxxx_xx_xx_create_game_products_table.php
│   │   ├── xxxx_xx_xx_create_categories_table.php
│   │   ├── xxxx_xx_xx_create_orders_table.php
│   │   └── xxxx_xx_xx_create_order_items_table.php
│   │
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── UserSeeder.php
│   │   └── GameProductSeeder.php
│   │
│   └── factories/
│       ├── UserFactory.php
│       └── GameProductFactory.php
│
├── routes/
│   ├── api.php                       # API routes
│   ├── web.php                       # Web routes
│   └── channels.php                  # Broadcasting
│
├── storage/
│   ├── app/public/                   # User uploads
│   ├── logs/                         # Log files
│   └── framework/
│       ├── cache/
│       ├── sessions/
│       └── views/
│
├── tests/
│   ├── Feature/
│   │   ├── GameProductTest.php
│   │   └── OrderTest.php
│   │
│   └── Unit/
│       ├── GameProductModelTest.php
│       └── OrderServiceTest.php
│
├── .env.example                      # Environment template
├── .gitignore                       # Git ignore
├── composer.json                    # Dependencies
├── phpunit.xml                      # Testing config
└── README.md                        # This file
```

---

## 🏗️ Layer-by-Layer Explanation

### 1. Controller Layer

**Fungsi:** Menangani request dari client dan routing  
**Tanggung Jawab:** Validasi input, memanggil service, mengembalikan response

```php
// app/Http/Controllers/Api/ProductController.php
class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}
    
    public function index()
    {
        $products = $this->service->getAllProducts();
        return response()->json(['success' => true, 'data' => $products]);
    }
}
```

### 2. Service Layer

**Fungsi:** Mengimplementasikan business logic  
**Tanggung Jawab:** Proses bisnis, validasi kompleks, interaksi antar-model

```php
// app/Services/ProductService.php
class ProductService
{
    public function __construct(private ProductRepository $repository) {}
    
    public function getAllProducts($filters = [])
    {
        return $this->repository->paginate(15, $filters);
    }
}
```

### 3. Repository Layer

**Fungsi:** Abstraksi akses data dari database  
**Tanggung Jawab:** Query building, data retrieval, CRUD operations

```php
// app/Repositories/ProductRepository.php
class ProductRepository
{
    public function paginate($perPage = 15, $filters = [])
    {
        return Product::query()
            ->filter($filters)
            ->paginate($perPage);
    }
}
```

### 4. Model Layer

**Fungsi:** Memetakan tabel database ke objek PHP  
**Tanggung Jawab:** Relationship definition, validation rules

```php
// app/Models/Product.php
class Product extends Model
{
    protected $fillable = ['name', 'price', 'category_id'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

## 📡 API Documentation

### Base URL

```
http://localhost:8000/api/v1
```

### Response Format

Setiap response mengikuti format standar:

```json
{
  "success": true,
  "message": "Operation successful",
  "data": {},
  "errors": null,
  "timestamp": "2024-01-15T10:30:00Z"
}
```

### HTTP Status Codes

| Code | Meaning |
|------|---------|
| `200` | OK - Request berhasil |
| `201` | Created - Resource berhasil dibuat |
| `204` | No Content - Request berhasil, no data |
| `400` | Bad Request - Data tidak valid |
| `401` | Unauthorized - Authentication diperlukan |
| `403` | Forbidden - Permission denied |
| `404` | Not Found - Resource tidak ditemukan |
| `422` | Unprocessable Entity - Validasi gagal |
| `429` | Too Many Requests - Rate limit exceeded |
| `500` | Internal Server Error - Error server |

---

## 🔐 Authentication Endpoints

### Register User

```http
POST /auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-01-15T10:30:00Z"
  }
}
```

### Login User

```http
POST /auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "1|eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "Bearer"
  }
}
```

### Logout

```http
POST /auth/logout
Authorization: Bearer {token}
```

### Get Current User

```http
GET /auth/me
Authorization: Bearer {token}
```

---

## 🎮 Game Products Endpoints

### Get All Products

```http
GET /products?page=1&per_page=15&search=mobile&category_id=1
Content-Type: application/json
```

**Response (200):**
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Mobile Legends Diamond",
      "price": 50000,
      "thumbnail": "storage/products/ml-diamond.jpg",
      "category": {
        "id": 1,
        "name": "Mobile Games"
      },
      "is_active": true,
      "created_at": "2024-01-15T10:30:00Z"
    }
  ],
  "pagination": {
    "total": 100,
    "per_page": 15,
    "current_page": 1,
    "last_page": 10
  }
}
```

### Get Product by ID

```http
GET /products/{id}
```

### Create Product (Admin Only)

```http
POST /products
Authorization: Bearer {admin_token}
Content-Type: multipart/form-data

name: Mobile Legends Diamond
price: 50000
description: Top up diamond untuk Mobile Legends
category_id: 1
thumbnail: <file>
is_active: true
```

### Update Product (Admin Only)

```http
PUT /products/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "name": "Mobile Legends Diamond Updated",
  "price": 55000,
  "is_active": true
}
```

### Delete Product (Admin Only)

```http
DELETE /products/{id}
Authorization: Bearer {admin_token}
```

---

## 📂 Categories Endpoints

### Get All Categories

```http
GET /categories
```

### Create Category (Admin Only)

```http
POST /categories
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "name": "Console Games"
}
```

---

## 📦 Orders Endpoints

### Get All Orders

```http
GET /orders?page=1&per_page=10&status=pending
Authorization: Bearer {token}
```

### Create Order

```http
POST /orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}
```

### Get Order Details

```http
GET /orders/{id}
Authorization: Bearer {token}
```

### Update Order Status (Admin Only)

```http
PATCH /orders/{id}/status
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "status": "completed"
}
```

**Valid Status:** pending, paid, processing, completed, cancelled

---

## 👤 Users Endpoints

### Get All Users (Admin Only)

```http
GET /users
Authorization: Bearer {admin_token}
```

### Update User Profile

```http
PUT /users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Jane Doe",
  "phone": "081234567890",
  "address": "Jl. Example No. 123"
}
```

### Change Password

```http
POST /users/{id}/change-password
Authorization: Bearer {token}
Content-Type: application/json

{
  "current_password": "old_password",
  "new_password": "new_password_123",
  "new_password_confirmation": "new_password_123"
}
```

---

## 🗄️ Database Schema

### Tabel: game_products

```sql
CREATE TABLE game_products (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    thumbnail VARCHAR(255),
    category_id BIGINT UNSIGNED,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

### Tabel: categories

```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabel: orders

```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_price INT NOT NULL,
    status ENUM('pending', 'paid', 'completed', 'failed'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Tabel: order_items

```sql
CREATE TABLE order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT DEFAULT 1,
    unit_price INT NOT NULL,
    created_at TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES game_products(id)
);
```

---

## 💻 Membuat Feature Baru

### Step 1: Database Schema

```bash
php artisan make:migration create_products_table
```

**database/migrations/xxxx_create_products_table.php:**
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->integer('price');
    $table->foreignId('category_id')->constrained();
    $table->timestamps();
});
```

### Step 2: Create Model

```bash
php artisan make:model Product -fs
```

**app/Models/Product.php:**
```php
class Product extends Model
{
    protected $fillable = ['name', 'price', 'category_id'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

### Step 3: Create Controller

```bash
php artisan make:controller Api/ProductController --resource --model=Product
```

**app/Http/Controllers/Api/ProductController.php:**
```php
class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }
    
    public function show(Product $product)
    {
        return response()->json($product);
    }
    
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }
}
```

### Step 4: Add Routes

**routes/api.php:**
```php
Route::prefix('v1')->group(function () {
    Route::apiResource('products', ProductController::class);
});
```

### Step 5: Create Request Validation

```bash
php artisan make:request StoreProductRequest
```

**app/Http/Requests/StoreProductRequest.php:**
```php
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:1000',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
```

### Step 6: Write Tests

```bash
php artisan make:test Feature/ProductTest
```

**tests/Feature/ProductTest.php:**
```php
class ProductTest extends TestCase
{
    public function test_can_get_products()
    {
        Product::factory()->count(5)->create();
        
        $response = $this->getJson('/api/v1/products');
        
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }
    
    public function test_can_create_product()
    {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)->postJson('/api/v1/products', [
            'name' => 'Test Product',
            'price' => 50000,
            'category_id' => 1,
        ]);
        
        $response->assertStatus(201);
    }
}
```

### Step 7: Run Tests

```bash
php artisan test
```

---

## 📊 Database Query Tips

### Eager Loading (Prevent N+1)

```php
// ❌ Bad - N+1 query problem
$products = Product::all();
foreach ($products as $product) {
    echo $product->category->name; // Extra query per product!
}

// ✅ Good - Eager load
$products = Product::with('category')->get();
foreach ($products as $product) {
    echo $product->category->name; // No extra queries
}
```

### Selecting Specific Columns

```php
// ✅ Good - Select hanya yang diperlukan
$products = Product::select('id', 'name', 'price')
    ->where('is_active', true)
    ->get();
```

### Filtering

```php
// Simple where
$products = Product::where('price', '>', 50000)->get();

// Multiple where
$products = Product::where('price', '>', 50000)
    ->where('is_active', true)
    ->get();

// Where in
$products = Product::whereIn('category_id', [1, 2, 3])->get();

// Between
$products = Product::whereBetween('price', [10000, 100000])->get();
```

---

## 🧪 Testing

### Unit Test

```php
namespace Tests\Unit;

class ProductTest extends TestCase
{
    public function test_product_can_be_created()
    {
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 50000
        ]);
        
        $this->assertEquals('Test Product', $product->name);
    }
}
```

### Feature Test

```php
namespace Tests\Feature;

class ProductApiTest extends TestCase
{
    public function test_api_returns_products()
    {
        Product::factory()->count(3)->create();
        
        $response = $this->getJson('/api/v1/products');
        
        $response
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure(['data' => ['*' => ['id', 'name', 'price']]]);
    }
}
```

### Running Tests

```bash
# Jalankan semua tests
php artisan test

# Jalankan test file spesifik
php artisan test tests/Feature/ProductApiTest.php

# Dengan coverage
php artisan test --coverage

# Hanya test yang fail terakhir
php artisan test --last-failed

# Test dengan pattern
php artisan test --filter testCanGetProducts
```

---

## 🐛 Debugging

### Tinker (REPL)

```bash
php artisan tinker

# Di dalam tinker:
>>> $user = User::first();
>>> $user->name;
>>> $user->update(['name' => 'New Name']);
>>> DB::table('users')->count();
```

### Logging

```php
// Log messages
Log::info('User logged in', ['user_id' => $userId]);
Log::warning('Low stock', ['product_id' => $productId]);
Log::error('Payment failed', ['order_id' => $orderId]);

// View logs
tail -f storage/logs/laravel.log
```

### Debugging dengan dd()

```php
// Dump dan die
dd($variable);

// Dump saja
dump($variable1, $variable2);
```

---

## 🎯 Coding Standards

### PSR-12 Compliance

Proyek ini mengikuti **PSR-12 (Extended Coding Style)** standard.

### Naming Conventions

**Classes:**
```php
// ✅ Good - PascalCase
class GameProductController {}
class OrderService {}

// ❌ Bad
class game_product_controller {}
```

**Methods & Functions:**
```php
// ✅ Good - camelCase
public function getAllProducts() {}
private function calculateTotal() {}

// ❌ Bad
public function get_all_products() {}
```

**Variables:**
```php
// ✅ Good - camelCase
$productName = 'Mobile Legends Diamond';
$isActive = true;

// ❌ Bad
$product_name = 'Mobile Legends Diamond';
```

**Constants:**
```php
// ✅ Good - SCREAMING_SNAKE_CASE
const MAX_PRODUCTS_PER_PAGE = 15;
const CACHE_TTL = 3600;
```

### Type Hints

```php
// ✅ Good - Type hints on all parameters
public function getProduct(int $id): GameProduct
{
    return GameProduct::findOrFail($id);
}

// ❌ Bad - No type hints
public function getProduct($id)
{
    return GameProduct::findOrFail($id);
}
```

### PHPDoc Comments

```php
// ✅ Good
/**
 * Get all game products with pagination.
 *
 * @param int $page Current page number
 * @param int $perPage Items per page
 * @return LengthAwarePaginator
 */
public function getAllProducts(int $page = 1, int $perPage = 15): LengthAwarePaginator
{
    return GameProduct::paginate($perPage, ['*'], 'page', $page);
}
```

### Line Length & Formatting

```php
// ✅ Good - Break long lines
$products = GameProduct::query()
    ->where('is_active', true)
    ->whereBetween('price', [10000, 100000])
    ->orderBy('created_at', 'desc')
    ->paginate(15);

// ❌ Bad - Too long
$products = GameProduct::query()->where('is_active', true)->paginate(15);
```

### Laravel Specific Standards

#### Route Organization

```php
// routes/api.php
Route::prefix('v1')->middleware(['api'])->group(function () {
    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    
    // Protected routes
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('products', ProductController::class);
        
        // Admin routes
        Route::middleware(['admin'])->group(function () {
            Route::post('/products/{id}/publish', [ProductController::class, 'publish']);
        });
    });
});
```

#### Model Definition

```php
class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'description',
        'is_active',
    ];
    
    protected $casts = [
        'price' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

## 📝 Git Workflow

### Branch Naming Convention

```
feature/short-description          # Fitur baru
bugfix/issue-123-short-description # Bug fix dengan issue number
refactor/short-description         # Refactoring
docs/short-description             # Documentation
test/short-description             # Test improvements
```

### Commit Messages (Conventional Commits)

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Type:**
- `feat` - Fitur baru
- `fix` - Bug fix
- `refactor` - Refactoring code
- `test` - Add/update tests
- `docs` - Documentation changes
- `style` - Code style changes
- `chore` - Dependency updates

**Contoh:**
```bash
git commit -m "feat(products): add product filtering by category"
git commit -m "fix(orders): resolve payment status not updating"
git commit -m "refactor(services): simplify business logic in order service"
git commit -m "test(products): add unit tests for product repository"
```

### Keep Fork Updated

```bash
# Fetch latest dari upstream
git fetch upstream

# Rebase ke latest main
git rebase upstream/main

# Force push ke your fork (hanya jika belum di-push)
git push -f origin feature/your-feature-name
```

---

## 🤝 Contributing Guidelines

### Code of Conduct

✅ Respectful Communication  
✅ Inclusive Environment  
✅ Constructive Feedback  
✅ Professional Behavior  

### Pull Request Process

1. **Fork repository** dan create feature branch
2. **Code** dengan following coding standards
3. **Write tests** untuk perubahan yang dibuat
4. **Push** ke fork Anda
5. **Create Pull Request** dengan deskripsi detail
6. **Address feedback** dari reviewer
7. **Merge** setelah approval

### PR Title & Description

**Title Format:**
```
[TYPE] Short description

Contoh:
[FEATURE] Add product filtering by category
[BUG FIX] Fix order payment status not updating
```

**Description Template:**
```markdown
## Description
Brief description of changes

## Related Issues
Fixes #123

## Changes Made
- Change 1
- Change 2

## Testing
- [ ] Unit tests added
- [ ] Feature tests added
- [ ] Tests passing

## Checklist
- [ ] Code follows PSR-12 standards
- [ ] Documentation updated
- [ ] No new warnings generated
```

---

## 🔍 Troubleshooting

### Problem 1: "No Application Encryption Key"

```bash
php artisan key:generate
```

### Problem 2: "Connection Refused" ke MySQL

```bash
# Check MySQL is running
mysql --version

# Verify .env configuration
cat .env | grep DB_

# Test connection manually
mysql -u root -p
```

### Problem 3: "Permission Denied" untuk Storage

```bash
chmod -R 775 storage bootstrap/cache
```

### Problem 4: "Class not found"

```bash
composer dump-autoload
php artisan config:clear
```

### Problem 5: "Migration table not found"

```bash
php artisan migrate:install
php artisan migrate
```

### Problem 6: "SQLSTATE Connection refused"

```bash
# Update .env DB variables
DB_HOST=127.0.0.1
DB_PORT=3306

# Test connection
php artisan tinker
>>> DB::connection()->getPDO()
```

### Problem 7: Port 8000 Sudah Terpakai

```bash
# Jalankan di port berbeda
php artisan serve --port=8001

# Atau force kill process
lsof -i :8000
kill -9 <PID>
```

---

## 📚 Useful Links

- [Laravel Documentation](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [API Resources](https://laravel.com/docs/eloquent-resources)
- [Testing Guide](https://laravel.com/docs/testing)
- [Sanctum Authentication](https://laravel.com/docs/sanctum)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [PSR-12 Standard](https://www.php-fig.org/psr/psr-12/)

---

## ✅ Development Workflow

```
1. Create feature branch
   git checkout -b feature/your-feature

2. Make changes
   - Create migration if needed
   - Create/modify models
   - Create/modify controllers
   - Add routes
   - Write tests

3. Test locally
   php artisan test

4. Commit changes
   git commit -m "feat: add new feature"

5. Push to your fork
   git push origin feature/your-feature

6. Create Pull Request

7. Address feedback

8. Merge to main
```

---

## 💡 Best Practices

✅ Selalu tulis tests untuk fitur baru  
✅ Gunakan eager loading untuk relationships  
✅ Jangan hardcode values - gunakan constants  
✅ Pisahkan logic ke Service layer  
✅ Comment kompleks logic, bukan obvious code  
✅ Update dokumentasi saat ada perubahan  
✅ Commit messages yang deskriptif  
✅ Code review sebelum merge  
✅ Follow PSR-12 standard  
✅ Maintain 80%+ code coverage  

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah **MIT License** - lihat file LICENSE untuk detail.

---

## 👥 Tim Development

**Rapid Store Backend Team**

---

## 📞 Support & Kontribusi

Untuk pertanyaan atau bantuan:
- 📧 Email: rickymoreno851@gmail.com
- 🐛 Issues: [GitHub Issues](https://github.com/rickymorenoar)
- 💬 Discussions: [GitHub Discussions](https://github.com/yourname/rapid-store/discussions)

---

**Last Updated:** Juni 2026  
**Version:** 1.0.0  
**Status:** Production Ready  
**Maintainers:** Rapid Store Team
# 📚 Rapid Store Backend - Dokumentasi Lengkap

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.5+-777BB4?style=flat-square&logo=php)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

Dokumentasi teknis lengkap untuk Backend Rapid Store Backend - sistem game top-up berbasis Laravel dan MySQL dengan fitur authentication, order management, dan role-based access control.

---

## 📋 Daftar Isi

- [Overview](#-overview)
- [Tech Stack](#-tech-stack)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Struktur Folder](#-struktur-folder-proyek)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Role & Permission](#-role--permission)
- [API Documentation](#-api-documentation)
- [Database Schema](#-database-schema)
- [Development](#-development)
- [Testing](#-testing)
- [Troubleshooting](#-troubleshooting)

---

## 🎯 Overview

**Rapid Store Backend** adalah sistem API untuk platform game top-up dengan:

- ✅ Token-based Authentication (Laravel Sanctum)
- ✅ Role-based Access Control (Customer & Admin)
- ✅ Order Management System
- ✅ Comprehensive API endpoints
- ✅ Rate Limiting untuk security
- ✅ CORS support untuk frontend

---

## ⚙️ Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| **Framework** | Laravel | 13.x |
| **Language** | PHP | 8.5+ |
| **Database** | MySQL | 8.0+ |
| **Authentication** | Sanctum | Built-in |
| **Testing** | PHPUnit | Built-in |
| **Server** | Apache/Nginx | Latest |

---

## 📦 Instalasi

### Prerequisites

```bash
# Cek PHP version (minimum 8.2)
php -v

# Cek Composer
composer --version

# Cek MySQL
mysql --version

# Cek Git
git --version
```

### Step-by-Step Installation

#### 1. Clone Repository

```bash
git clone https://github.com/rickymorenoar/rapid-store-backend.git
cd rapid-store-backend
```

#### 2. Install Dependencies

```bash
composer install
```

#### 3. Setup Environment

```bash
# Copy environment template
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Configure Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rapid-store
DB_USERNAME=root
DB_PASSWORD=
```

Create database:

```bash
mysql -u root -p
CREATE DATABASE rapid_store;
CREATE DATABASE rapid_store_test;
EXIT;
```

#### 5. Run Migrations

```bash
# Apply database schema
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

#### 6. Start Development Server

```bash
php artisan serve
```

Server berjalan di: **http://localhost:8000**

---

## 🔧 Konfigurasi

### Environment Variables

Edit `.env` dengan konfigurasi berikut:

```env
# Application
APP_NAME="Rapid Store"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rapid_store
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=sync

# CORS (untuk frontend)
ALLOWED_ORIGINS=http://localhost:5173,http://localhost:3000

# Sanctum (Token expiration dalam menit)
SANCTUM_TOKENS_EXPIRATION=525600

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### CORS Configuration

Edit `config/cors.php`:

```php
'allowed_origins' => explode(',', env('ALLOWED_ORIGINS', 'http://localhost:5173')),
```

### Test Database Connection

```bash
php artisan tinker
>>> DB::connection()->getPDO()
```

---

## 📁 Struktur Folder Proyek

```
rapid-store-backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php           ← Login/Logout
│   │   │   ├── OrderController.php          ← Order management
│   │   │   ├── UserController.php           ← User profile
│   │   │   └── CheckAdminRole.php           ← Admin middleware
│   │   │
│   │   ├── Requests/                        ← Form validation
│   │   │   ├── LoginRequest.php
│   │   │   ├── StoreOrderRequest.php
│   │   │   └── UpdateOrderStatusRequest.php
│   │   │
│   │   ├── Resources/                       ← API resource transformation
│   │   │
│   │   └── Middleware/
│   │       ├── Authenticate.php
│   │       ├── admin.php                    ← Admin check
│   │       └── ...
│   │
│   ├── Models/
│   │   ├── User.php                         ← User model (Customer & Admin)
│   │   ├── Order.php                        ← Order model
│   │   └── ...
│   │
│   ├── Events/
│   ├── Jobs/
│   ├── Console/Commands/
│   └── Providers/
│
├── routes/
│   ├── api.php                              ← API routes
│   ├── web.php                              ← Web routes
│   └── console.php
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_orders_table.php
│   │   └── ...
│   │
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── UserSeeder.php
│   │   └── OrderSeeder.php
│   │
│   └── factories/
│
├── config/
│   ├── app.php
│   ├── database.php
│   ├── cors.php
│   └── ...
│
├── resources/
├── storage/logs/
├── tests/
├── .env.example
├── composer.json
├── phpunit.xml
└── README.md
```

---

## 🏗️ Arsitektur Sistem

### Request Flow

```
Frontend Request
    ↓
Route (routes/api.php)
    ↓
Middleware (Authentication, CORS, etc)
    ↓
Controller (Process request)
    ↓
Request Validation
    ↓
Service Layer (Business Logic)
    ↓
Model (Database)
    ↓
Response (JSON)
    ↓
Frontend
```

### Layer Architecture

**Controller Layer** - Menangani request dan response  
**Service Layer** - Business logic dan proses bisnis  
**Repository Layer** - Data access abstraction  
**Model Layer** - Database schema definition  

---

## 👥 Role & Permission

### Customer Role

**Permissions:**
- ✅ Register account
- ✅ Login/Logout
- ✅ View own profile
- ✅ View own order history
- ✅ Create new order
- ✅ View own order details

**Access:**
```
GET    /api/auth/me              → View profile
POST   /api/logout               → Logout
GET    /api/orders               → View own orders
GET    /api/orders/{id}          → View own order detail
POST   /api/orders               → Create new order
```

### Admin Role

**Permissions:**
- ✅ All customer permissions
- ✅ View all customers
- ✅ View all orders (dari semua customer)
- ✅ Update order status (paid, success, cancelled, etc)
- ✅ Manage users

**Access:**
```
GET    /api/users                → View all users
GET    /api/orders               → View all orders
GET    /api/orders/{id}          → View any order detail
PATCH  /api/orders/{id}/status   → Update order status
DELETE /api/orders/{id}          → Cancel/delete order
```

### Status Order

Available order statuses:
- `pending` - Menunggu pembayaran
- `paid` - Sudah dibayar
- `shipped` - Sedang diproses
- `success` - Berhasil
- `cancelled` - Dibatalkan

---

## 📡 API Documentation

### Base URL

```
http://localhost:8000/api
```

### Authentication

Semua endpoint (kecuali login) memerlukan Bearer token di header:

```http
Authorization: Bearer {token}
```

---

## 🔐 Authentication Endpoints

### Register (Public)

```http
POST /api/register
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
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "customer",
    "created_at": "2026-07-04T10:30:00Z"
  }
}
```

### Login (Public)

```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "message": "Login successful",
  "token": "1|eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "customer"
  }
}
```

### Get Current User

```http
GET /api/auth/me
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "customer",
    "created_at": "2026-07-04T10:30:00Z"
  }
}
```

### Logout

```http
POST /api/logout
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "message": "Logout successful"
}
```

---

## 📦 Order Endpoints

### Get Orders (Customer & Admin)

**Customer:** Lihat order mereka sendiri  
**Admin:** Lihat semua order dari semua customer

```http
GET /api/orders
Authorization: Bearer {token}
```

**Query Parameters:**
```
?page=1&per_page=10&status=pending&sort=created_at
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "order_number": "ORD-2026-001",
      "user_id": 1,
      "total_price": 100000,
      "status": "pending",
      "created_at": "2026-07-04T10:30:00Z",
      "updated_at": "2026-07-04T10:30:00Z"
    }
  ],
  "pagination": {
    "total": 25,
    "per_page": 10,
    "current_page": 1,
    "last_page": 3
  }
}
```

### Get Order Detail

```http
GET /api/orders/{id}
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "order_number": "ORD-2026-001",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "total_price": 100000,
    "status": "pending",
    "items": [
      {
        "id": 1,
        "product_name": "Mobile Legends Diamond",
        "quantity": 2,
        "unit_price": 50000,
        "subtotal": 100000
      }
    ],
    "created_at": "2026-07-04T10:30:00Z"
  }
}
```

### Create Order (Customer)

```http
POST /api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 2
}
```

**Response (201):**
```json
{
  "message": "Order created successfully",
  "data": {
    "id": 2,
    "order_number": "ORD-2026-002",
    "user_id": 1,
    "total_price": 100000,
    "status": "pending",
    "created_at": "2026-07-04T10:35:00Z"
  }
}
```

### Update Order Status (Admin Only)

```http
PATCH /api/orders/{id}/status
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "status": "success"
}
```

**Valid Status Values:**
- `pending` - Menunggu pembayaran
- `paid` - Sudah dibayar
- `shipped` - Sedang diproses
- `success` - Berhasil
- `cancelled` - Dibatalkan

**Response (200):**
```json
{
  "message": "Order status updated successfully",
  "data": {
    "id": 1,
    "order_number": "ORD-2026-001",
    "status": "paid",
    "updated_at": "2026-07-04T10:40:00Z"
  }
}
```

**Error (403) - Jika bukan admin:**
```json
{
  "message": "Unauthorized. Admin access required.",
  "error": "Forbidden"
}
```

---

## 👤 User Endpoints

### Get Current User Profile

```http
GET /api/auth/me
Authorization: Bearer {token}
```

### Get All Users (Admin Only)

```http
GET /api/users
Authorization: Bearer {admin_token}
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "customer",
      "created_at": "2026-07-04T10:30:00Z"
    },
    {
      "id": 2,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin",
      "created_at": "2026-07-04T10:25:00Z"
    }
  ],
  "pagination": {
    "total": 50,
    "per_page": 15,
    "current_page": 1
  }
}
```

### Update User Profile

```http
PUT /api/users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Jane Doe",
  "phone": "081234567890"
}
```

---

## 🗄️ Database Schema

### Users Table

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Orders Table

```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    total_price INT NOT NULL,
    status ENUM('pending', 'paid', 'processing', 'success', 'cancelled', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

## 💻 Development

### Artisan Commands

```bash
# List semua commands
php artisan list

# Start development server
php artisan serve

# Interactive shell
php artisan tinker

# Create migration
php artisan make:migration create_products_table

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Run seeders
php artisan db:seed

# Create model
php artisan make:model Product

# Create controller
php artisan make:controller Api/ProductController --resource

# Create request validation
php artisan make:request StoreProductRequest

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Code Structure Best Practices

#### Controller Example

```php
namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Customer hanya bisa lihat order mereka sendiri
        if ($user->role === 'customer') {
            $orders = Order::where('user_id', $user->id)->paginate();
        } 
        // Admin bisa lihat semua order
        else {
            $orders = Order::paginate();
        }
        
        return response()->json([
            'data' => $orders->items(),
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
            ]
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Hanya admin bisa update status
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Order status updated successfully',
            'data' => $order
        ]);
    }
}
```

#### Model Example

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password'];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
```

---

## 🧪 Testing

### Run All Tests

```bash
php artisan test
```

### Run Specific Test

```bash
php artisan test tests/Feature/AuthTest.php
```

### With Coverage Report

```bash
php artisan test --coverage
```

### Test Example

```php
namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_customer_can_view_own_orders()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        
        $response = $this->actingAs($customer)->getJson('/api/orders');
        
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'pagination']);
    }

    public function test_admin_can_view_all_orders()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->getJson('/api/orders');
        
        $response->assertStatus(200);
    }

    public function test_admin_can_update_order_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = Order::factory()->create();
        
        $response = $this->actingAs($admin)->patchJson(
            "/api/orders/{$order->id}/status",
            ['status' => 'paid']
        );
        
        $response->assertStatus(200);
        $this->assertEquals('paid', $order->fresh()->status);
    }

    public function test_customer_cannot_update_order_status()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $order = Order::factory()->create();
        
        $response = $this->actingAs($customer)->patchJson(
            "/api/orders/{$order->id}/status",
            ['status' => 'paid']
        );
        
        $response->assertStatus(403);
    }
}
```

---

## 🔍 Troubleshooting

### Problem: "Class not found" Error

```bash
composer dump-autoload
php artisan config:clear
```

### Problem: Database Connection Failed

```bash
# Verify .env
grep DB_ .env

# Test MySQL
mysql -u root -p

# Test Laravel connection
php artisan tinker
>>> DB::connection()->getPDO()
```

### Problem: Permission Denied on Storage

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Problem: Port 8000 Already in Use

```bash
# Use different port
php artisan serve --port=8001

# Or kill existing process
lsof -i :8000
kill -9 <PID>
```

### Problem: CORS Error

Edit `config/cors.php`:

```php
'allowed_origins' => [
    'http://localhost:5173',
    'http://localhost:8000',
    'https://yourdomain.com'
],
```

### Problem: Token Expired

User perlu login kembali untuk mendapat token baru. Token expiration bisa disesuaikan di `.env`:

```env
SANCTUM_TOKENS_EXPIRATION=525600  # dalam menit (1 tahun)
```

### Problem: Unauthorized Error (403)

Pastikan user memiliki role yang sesuai:
- Admin endpoints hanya bisa diakses oleh user dengan role `admin`
- Customer endpoints bisa diakses oleh user dengan role `customer`

---

## 🔐 Security Features

### Authentication
- ✅ Password hashing dengan bcrypt
- ✅ Token-based auth dengan Sanctum
- ✅ Secure password reset

### Authorization
- ✅ Role-based access control
- ✅ Middleware untuk admin check
- ✅ Policy-based authorization

### API Security
- ✅ CORS configuration
- ✅ Rate limiting (5 requests/menit)
- ✅ Input validation
- ✅ SQL injection prevention (via Eloquent)

---

## 📊 Project Statistics

```
Framework:        Laravel 13.x
PHP Standard:     PSR-12
Authentication:   Sanctum
Database:         MySQL 8.0+
Routes:           15+
Controllers:      4
Models:           5+
Migrations:       10+
Tests:            20+
```

---

## 🔗 Useful Links

- [Laravel Documentation](https://laravel.com/docs)
- [Sanctum Authentication](https://laravel.com/docs/sanctum)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [HTTP Status Codes](https://httpwg.org/specs/rfc7231.html#status.codes)
- [RESTful API Best Practices](https://restfulapi.net)

---

## 📝 Coding Standards

Project mengikuti **PSR-12** standard untuk PHP.

### Naming Conventions

```php
// Classes: PascalCase
class OrderController {}
class OrderRepository {}

// Methods: camelCase
public function getOrdersByStatus() {}

// Variables: camelCase
$currentUser = auth()->user();

// Constants: SCREAMING_SNAKE_CASE
const MAX_RETRY_ATTEMPTS = 3;
```

### Code Comments

```php
// ✅ Good - Explain WHY, not WHAT
public function updateOrderStatus($id, $status)
{
    // Customer hanya bisa lihat order mereka sendiri
    if (auth()->user()->role === 'customer') {
        abort(403);
    }
}

// ❌ Bad - Obvious comment
$user = auth()->user(); // Get current user
```

---

## 🚀 Git Workflow

### Branch Naming

```
feature/add-payment-gateway
bugfix/fix-order-status-update
refactor/improve-validation
docs/update-api-documentation
```

### Commit Messages

```
feat: add order status update for admin
fix: resolve customer cannot view own orders
refactor: simplify order repository
test: add tests for admin permissions
docs: update API documentation
```

---

## 📄 License

MIT License - See LICENSE file for details

---

## 👥 Team

**Rapid Store Development Team**

---

## 📞 Support & Contact

Untuk pertanyaan atau bug reports:

- 📧 **Email**: rickymoreno851@gmail.com
- 🐛 **Issues**: [GitHub Issues](https://github.com/rickymorenoar)

---

## 📈 Roadmap

### v1.0 (Current)
- ✅ Authentication system (Register, Login, Logout)
- ✅ Customer role (View own orders)
- ✅ Admin role (View all orders, Update status)
- ✅ Order management system
- ✅ API endpoints

### v1.1 (Next)
- 🔄 Payment gateway integration
- 🔄 Email notifications
- 🔄 Order tracking
- 🔄 Analytics dashboard

### v2.0 (Future)
- 📌 GraphQL API
- 📌 Real-time notifications
- 📌 Advanced reporting
- 📌 Mobile app support

---

**Last Updated:** Juny 2026  
**Version:** 1.0.0  
**Status:** ✅ Production Ready  
**Maintained By:** Rapid Store Team
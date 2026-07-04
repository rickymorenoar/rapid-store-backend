# 🎮 Rapid Store Backend API

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.5+-777BB4?style=flat-square&logo=php)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-brightgreen?style=flat-square)](#)

Backend API untuk platform game top-up **Rapid Store**. Sistem yang aman, scalable, dan production-ready dengan authentication berbasis Sanctum, role-based access control, dan comprehensive order management.

---

## 📋 Daftar Isi

- [Quick Start](#-quick-start)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [API Documentation](#-api-documentation)
- [Development](#-development)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🚀 Quick Start

### Minimal Setup (3 menit)

```bash
# 1. Clone repository
git clone https://github.com/rickymorenoar/rapid-store-backend.git
cd rapid-store-backend

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Database
php artisan migrate --seed

# 5. Start server
php artisan serve
```

Server berjalan di: **http://localhost:8000**

---

## ✨ Features

### Core Features
- ✅ **User Authentication** - Login/Logout dengan token-based auth (Sanctum)
- ✅ **Role Management** - User dan Admin roles dengan permission control
- ✅ **Order Management** - Create, read, update order status
- ✅ **API Throttling** - Rate limiting (5 req/menit) untuk security
- ✅ **Error Handling** - Comprehensive exception handling & logging
- ✅ **CORS Support** - Configured untuk multiple frontend origins

### Security Features
- 🔐 Laravel Sanctum for API authentication
- 🛡️ CSRF protection on web routes
- 🔒 Password hashing dengan bcrypt
- 📋 Middleware-based role validation
- 🚫 Request validation dan sanitization

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

## 📁 Project Structure

```
rapid-store-backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       ← Login/Logout logic
│   │   │   ├── OrderController.php      ← Order management
│   │   │   ├── UserController.php       ← User management
│   │   │   └── CheckAdminRole.php       ← Admin check
│   │   ├── Requests/                    ← Form validation
│   │   └── Middleware/                  ← Custom middleware
│   │
│   ├── Models/
│   │   ├── User.php                     ← User model
│   │   ├── Order.php                    ← Order model
│   │   └── ...
│   │
│   ├── Events/                          ← Event broadcasting
│   ├── Jobs/                            ← Queued jobs
│   ├── Console/
│   │   └── Commands/                    ← Artisan commands
│   │
│   └── Providers/
│       ├── AppServiceProvider.php       ← Service registration
│       ├── AuthServiceProvider.php      ← Auth policies
│       └── ...
│
├── routes/
│   ├── api.php                          ← API routes (main)
│   ├── web.php                          ← Web routes
│   └── console.php                      ← Console commands
│
├── database/
│   ├── migrations/                      ← Schema definitions
│   ├── seeders/                         ← Data seeders
│   └── factories/                       ← Model factories
│
├── config/                              ← Configuration files
│   ├── app.php
│   ├── database.php
│   ├── cors.php                         ← CORS configuration
│   └── ...
│
├── resources/
│   ├── views/                           ← Blade templates
│   ├── css/                             ← Stylesheets
│   └── js/                              ← JavaScript files
│
├── storage/
│   ├── logs/                            ← Application logs
│   ├── framework/                       ← Framework cache
│   └── app/                             ← User uploads
│
├── tests/
│   ├── Feature/                         ← API tests
│   ├── Unit/                            ← Unit tests
│   └── TestCase.php
│
├── bootstrap/                           ← Bootstrap files
├── public/                              ← Web root
├── vendor/                              ← Composer packages
├── .env.example                         ← Environment template
├── composer.json                        ← PHP dependencies
├── phpunit.xml                          ← Testing config
├── artisan                              ← Artisan CLI
└── README.md                            ← This file
```

**Untuk dokumentasi lengkap struktur, lihat [BACKEND.md](./backend.md)**

---

## 📦 Installation

### Requirements

| Software | Version | Command |
|----------|---------|---------|
| PHP | 8.5+ | `php -v` |
| Composer | 2.0+ | `composer -v` |
| MySQL | 8.0+ | `mysql --version` |
| Git | Latest | `git --version` |

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

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rapid_store
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

Visit: **http://localhost:8000**

---

## 🔧 Configuration

### Environment Variables

Key configurations in `.env`:

```env
# App
APP_NAME="Rapid Store"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rapid_store
DB_USERNAME=root
DB_PASSWORD=

# CORS (for frontend connection)
ALLOWED_ORIGINS=http://localhost:5173,http://localhost:3000

# Sanctum (Token expiration in minutes)
SANCTUM_TOKENS_EXPIRATION=525600
```

### Database Connection

Verify connection:

```bash
php artisan tinker
>>> DB::connection()->getPDO()
```

### CORS Configuration

Edit `config/cors.php` untuk allow frontend origins:

```php
'allowed_origins' => explode(',', env('ALLOWED_ORIGINS', 'http://localhost:5173')),
```

---

## 📡 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication

Endpoints dilindungi dengan **token-based authentication** menggunakan Sanctum.

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "message": "Login successful",
  "token": "1|abcdef123456...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "role": "user"
  }
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

### Order Management

#### Get Orders (User)
```http
GET /api/orders
Authorization: Bearer {token}
```

#### Create Order
```http
POST /api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 2
}
```

#### Update Order Status (Admin Only)
```http
PATCH /api/orders/{id}/status
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "status": "completed"
}
```

#### Get All Orders (Admin Only)
```http
GET /api/orders
Authorization: Bearer {admin_token}
```

### Rate Limiting

API dibatasi **5 requests per menit** per IP address.

**Response (429)** saat limit exceeded:
```json
{
  "message": "Too many requests",
  "retry_after": 60
}
```

---

## 💻 Development

### Common Commands

```bash
# Artisan CLI
php artisan list                           # Show all commands
php artisan serve                          # Start dev server
php artisan tinker                         # Interactive shell

# Database
php artisan make:migration create_table    # Create migration
php artisan migrate                        # Run migrations
php artisan migrate:rollback               # Rollback last
php artisan db:seed                        # Run seeders

# Models & Controllers
php artisan make:model Order               # Create model
php artisan make:controller OrderController # Create controller
php artisan make:request StoreOrderRequest # Create request

# Cache & Config
php artisan cache:clear                    # Clear cache
php artisan config:clear                   # Clear config
php artisan route:clear                    # Clear routes
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/AuthTest.php

# With coverage report
php artisan test --coverage
```

### Code Standards

Project mengikuti **PSR-12** standard. Format kode sebelum commit:

```bash
# Install formatter (optional)
composer require --dev laravel/pint

# Format code
./vendor/bin/pint
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
# Check MySQL is running
mysql -u root -p

# Verify .env configuration
grep DB_ .env

# Test connection
php artisan tinker
>>> DB::connection()->getPDO()
```

### Problem: Permission Denied on storage folder

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Problem: Token Expired

Tokens expire setelah periode yang ditentukan di `SANCTUM_TOKENS_EXPIRATION`. User perlu login kembali untuk mendapat token baru.

### Problem: CORS Error

Edit `config/cors.php` dan tambahkan frontend URL ke `allowed_origins`:

```php
'allowed_origins' => [
    'http://localhost:5173',
    'https://yourdomain.com'
],
```

### Problem: Port 8000 Already in Use

```bash
# Use different port
php artisan serve --port=8001

# Or kill existing process
lsof -i :8000
kill -9 <PID>
```

---

## 🤝 Contributing

Kami welcome contributions! Bisa langsung chat email ('rickymoreno851@gmail.com') untuk contributor rapid-store

### Git Workflow

```bash
# 1. Create feature branch
git checkout -b feature/amazing-feature

# 2. Make changes & commit
git commit -m "feat: add amazing feature"

# 3. Push to your fork
git push origin feature/amazing-feature

# 4. Create Pull Request
```

### Code Review Checklist

- ✅ Kode mengikuti PSR-12 standard
- ✅ Tests sudah ditulis & passing
- ✅ Documentation updated
- ✅ No console logs/debug code
- ✅ Breaking changes dijelaskan

---

## 📚 Documentation

| File | Deskripsi |
|------|-----------|
| **README.md** | Overview & quick start (file ini) |
| **[backend.md](./backend.md)** | Dokumentasi lengkap backend |
| **[.env.example](./.env.example)** | Environment template dengan penjelasan |

---

## 📊 Project Statistics

```
Lines of Code:    ~2,500
Routes:           15+
Models:           5+
Controllers:      4+
Tests:            20+
Code Coverage:    80%+
PHP Standard:     PSR-12
```

---

## 🔗 Useful Links

- [Laravel Documentation](https://laravel.com/docs)
- [Sanctum Authentication](https://laravel.com/docs/sanctum)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [RESTful API Best Practices](https://restfulapi.net)
- [HTTP Status Codes](https://httpwg.org/specs/rfc7231.html#status.codes)

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 👥 Team

**Rapid Store Development Team**

- Backend: Rapid Store Team
- Frontend: [Link to frontend repo]
- DevOps: Infrastructure Team

---

## 📞 Support & Contact

Untuk pertanyaan atau bug reports:

- 📧 **Email**: rickymoreno851@gmail.com
- 🐛 **Issues**: [GitHub Issues](https://github.com/rickymorenoar)
- 📱 **Discord**: [Join Server](https://discord.gg/yzXUVJYbs)

---

## 📈 Roadmap

### v1.0 (Current)
- ✅ Authentication system
- ✅ Order management
- ✅ Role-based access control
- ✅ API endpoints

### v1.1 (Next)
- 🔄 Payment gateway integration
- 🔄 Order tracking
- 🔄 Analytics dashboard
- 🔄 Notification system

### v2.0 (Future)
- 📌 GraphQL API
- 📌 Real-time notifications (WebSocket)
- 📌 Advanced reporting
- 📌 Multi-language support

---

## 🙏 Acknowledgments

- Laravel community & documentation
- Contributors & maintainers
- All the open-source packages used

---

## ⭐ Show Your Support

Jika project ini membantu, please star ⭐ repository ini!

```bash
# Clone, develop, and contribute!
git clone https://github.com/yourname/rapid-store-backend.git
```

---

**Last Updated:** Juny 2026 
**Version:** 1.0.0  
**Status:** ✅ Production Ready  
**Maintained By:** Rapid Store Team

---

<div align="center">

Made with Brain by Rapid Store Team

[⬆ Back to Top](#-rapid-store-backend-api)

</div>
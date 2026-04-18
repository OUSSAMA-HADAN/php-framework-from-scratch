#  PHP Mini Framework

A lightweight, hand-rolled PHP framework built with modern PHP 8+ features and PSR standards.  
No ORM. No magic. Just clean architecture.

---

## Features

- **PSR-7** HTTP messages (request / response)
- **PSR-15** Middleware pipeline
- **PSR-11** Dependency injection via PHP-DI
- **Repository Pattern + Data Mapper** — stored procedures, no ORM
- **League Route** for clean, fast routing
- **League Plates** for PHP-native templating
- **Session-based authentication** with bcrypt password hashing
- **Bootstrap 5** UI out of the box

---

## Requirements

- PHP 8.1+
- Composer
- MySQL 5.7+ / MariaDB
- A web server with URL rewriting (Apache `.htaccess` or Nginx)

---

## Installation

```bash
git clone https://github.com/your-username/shopframe.git
cd shopframe
composer install
cp .env.example .env
```

Edit `.env` with your database credentials:

```env
DB_HOST=127.0.0.1
DB_NAME=shop_db
DB_USERNAME=root
DB_PASSWORD=
```

Import the database schema and stored procedures from `database/schema.sql`, then start the development server:

```bash
composer serve
```

This runs `php -S localhost:7010 -t public`. Open [http://localhost:7010](http://localhost:7010) in your browser.

---

## Project Structure

```
shopframe/
├── public/
│   └── index.php               # Entry point
├── src/
│   ├── bootstrap.php           # Framework boot sequence
│   ├── Controller/
│   │   └── AbstractController.php
│   ├── Controllers/            # Application controllers
│   ├── Entities/               # Plain PHP entity objects
│   ├── Mappers/                # PDO row → Entity hydration
│   ├── Middleware/             # Application middleware
│   ├── Repositories/           # Stored procedure calls
│   └── Framework/
│       ├── Database/           # Interfaces: Repository, Database
│       ├── Middleware/         # AbstractMiddleware base class
│       └── Template/           # Renderer interface + implementations
├── views/                      # Plates PHP templates
├── config/
│   ├── definitions.php         # PHP-DI service bindings
│   └── routes.php              # Route definitions
└── .env.example
```

---

## Architecture

### Request Lifecycle

```
HTTP Request
  → public/index.php
  → src/bootstrap.php
      → PHP-DI container built
      → Routes registered
      → Middleware applied
      → Controller dispatched
      → PSR-7 Response emitted
```

### Database Layer

The framework uses the **Repository Pattern** on top of **stored procedures**.  
No ORM — the database owns its query logic.

```
Controller
  → RepositoryInterface
      → Repository        (calls stored procedures via PDO)
          → DataMapper    (maps raw rows → Entity objects)
              → Entity    (plain PHP object, no DB knowledge)
```

### Adding a New Entity

1. Create `src/Entities/MyEntity.php`
2. Create `src/Framework/Database/MyEntityRepositoryInterface.php`
3. Create `src/Mappers/MyEntityMapper.php`
4. Create `src/Repositories/MyEntityRepository.php`
5. Register in `config/definitions.php`
6. Add routes in `config/routes.php`

### Adding Middleware

Extend `Framework\Middleware\AbstractMiddleware`, implement `process()`, register in `config/definitions.php`, and attach to a route group in `config/routes.php`.

---

## Authentication

Session-based auth is built in.

| Route | Description |
|---|---|
| `GET /login` | Login form |
| `POST /login` | Authenticate |
| `GET /register` | Registration form |
| `POST /register` | Create account |
| `GET /logout` | Destroy session |

Protected routes are wrapped in a route group with `AuthMiddleware` attached.  
To protect a new route, add it inside the protected group in `config/routes.php`.

---

## Routes

| Method | URL | Action |
|---|---|---|
| GET | `/` | Home |
| GET | `/products` | List products |
| GET | `/products/create` | Create form |
| POST | `/products` | Store product |
| GET | `/product/{id}` | Product detail |
| GET | `/product/{id}/edit` | Edit form |
| POST | `/product/{id}/update` | Update product |
| POST | `/product/{id}/delete` | Delete product |
| GET | `/categories` | List categories |
| GET | `/categories/create` | Create form |
| POST | `/categories` | Store category |
| GET | `/category/{id}` | Category detail |
| GET | `/category/{id}/edit` | Edit form |
| POST | `/category/{id}/update` | Update category |
| POST | `/category/{id}/delete` | Delete category |

---

## Tech Stack

| Package | Purpose |
|---|---|
| `league/route` | Routing |
| `php-di/php-di` | Dependency injection |
| `league/plates` | Templating |
| `guzzlehttp/psr7` | PSR-7 HTTP messages |
| `httpsoft/http-emitter` | Response emitter |
| `vlucas/phpdotenv` | Environment variables |

---

## License

MIT — free to use, modify, and distribute.

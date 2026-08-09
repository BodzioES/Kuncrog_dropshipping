# 🛒 Kuncrog Shop

**Hello!** This is an online store project (web-store) based on the dropshipping model, built in **Laravel 11** (PHP 8.2+).

📌 **Live store:** ➡️ [**ecommerce-shop.kuncrog.com**](https://ecommerce-shop.kuncrog.com)

---

## ⚙️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 11 (PHP 8.2+) |
| **Database** | MariaDB 11.4 (SQL dump to import) |
| **Frontend** | Blade + Bootstrap (laravel/ui) |
| **Deployment** | Docker Compose: `app` (PHP-FPM) + `web` (nginx) + `db` (MariaDB) |
| **Server** | VPS (OVHcloud), Ubuntu, HTTPS (Let's Encrypt) |

---

## 🧩 Store Features (current)

- 🏠 **Homepage and categories** of products
- 🛍️ **Product listing** with search
- 🛒 **Cart** (add, update quantity, remove)
- 💳 **Checkout / Orders** — guest and logged-in customer support, payment & shipping method selection, cart preview
- 👤 **Customer login and registration** (with addresses in the address book)
- 🧾 **Order history** for the user, with details view and PDF invoice
- 🔐 **Admin panel** — manage products, categories, orders, methods
- 🖼️ Product images stored in `storage/app/public`

---

## 🚀 Local Setup

```bash
cd kuncrog_app
composer install
cp .env.example .env        # set APP_URL, database credentials
php artisan key:generate
# create the kuncrog_database and import kuncrog_database.sql
php artisan serve

---

## 🐳 Wdrożenie produkcyjne (Docker)

Struktura wdrożenia:

```
Dockerfile                          # multi-stage: Node build → Composer → PHP-FPM
docker-compose.yml                  # db (MariaDB) + app (PHP-FPM) + web (nginx)
deploy/
  docker/                           # entrypoint, php.ini files, opcache
  nginx/                            # site config (HTTP→HTTPS redirect)
  scripts/                          # setup-server.sh, setup-ssl.sh, deploy.sh
kuncrog_database.sql                # DB dump imported on first start
```

```bash
docker compose up -d --build
```


# 🛒 Kuncrog Shop

**Witaj!** To jest projekt sklepu internetowego (web-store) opartego o model dropshipping, zbudowany w **Laravel 11** (PHP 8.2+).

📌 **Sklep działa na żywo:** ➡️ [**ecommerce-shop.kuncrog.com**](https://ecommerce-shop.kuncrog.com)

---

## ⚙️ Technologie

| Warstwa | Technologia |
|--------|-------------|
| **Backend** | Laravel 11 (PHP 8.2+) |
| **Baza danych** | MariaDB 11.4 (SQL do wgrania) |
| **Frontend** | Blade + Bootstrap (laravel/ui) |
| **Wdrożenie** | Docker Compose: `app` (PHP-FPM) + `web` (nginx) + `db` (MariaDB) |
| **Serwer** | VPS (OVHcloud), Ubuntu, HTTPS (Let's Encrypt) |

---

## 🧩 Funkcje sklepu (istniejące)

- 🏠 **Strona główna i kategorie** produktów
- 🛍️ **Lista produktów** z wyszukiwaniem
- 🛒 **Koszyk** (dodawanie, aktualizacja ilości, usuwanie)
- 💳 **Checkout / zamówienia** — obsługa gościa i zalogowanego klienta, wybór metody płatności i dostawy, podgląd koszyka
- 👤 **Logowanie i rejestracja klientów** (wraz z adresami w książce adresowej)
- 🧾 **Historia zamówień** użytkownika z podglądem szczegółów i fakturą PDF
- 🔐 **Panel administratora** — zarządzanie produktami, kategoriami, zamówieniami, metodami
- 👁️ **Śledzenie wizyt i geolokalizacja** (z cache'owaniem 7 dni)
- 🖼️ Zdjęcia produktów przechowywane w `storage/app/public`

---

## 🚀 Uruchomienie lokalne

```bash
cd kuncrog_app
composer install
cp .env.example .env        # ustaw APP_URL, dane bazy
php artisan key:generate
# stwórz bazę kuncrog_database i zaimportuj kuncrog_database.sql
php artisan serve
```

---

## 🐳 Wdrożenie produkcyjne (Docker)

Struktura wdrożenia:

```
Dockerfile                          # multi-stage: Node build → Composer → PHP-FPM
docker-compose.yml                  # db (MariaDB) + app (PHP-FPM) + web (nginx)
deploy/
  docker/                           # entrypoint, pliki php.ini, opcache
  nginx/                            # konfiguracja witryny (HTTP→HTTPS redirect)
  scripts/                          # setup-server.sh, setup-ssl.sh, deploy.sh
kuncrog_database.sql                # dump bazy importowany przy pierwszym starcie
```

```bash
docker compose up -d --build
```

> Szczegółowa instrukcja krok po kroku znajduje się w `DEPLOY.md`.

---

## 🧭 Plan rozwoju

Prace nad kolejnymi funkcjami są śledzone jako **issue na GitHubie**:
- automatyczne odnawianie połączenia po zerwaniu sieci,
- konta i panel pracownika (logowanie, grafik, dostępność),
- bezpieczne logowanie administratora,
- wyłączanie dania/ produktu z menu oraz zniżki,
- rejestracja klienta z punktami lojalnościowymi i potwierdzeniem e-mail,
- prywatne endpointy (admin / pracownik / kuchnia) za VPN,
- link współdzielenia (QR) z trudnym hashem.

---

## 📄 Licencja

Projekt prywatny — `proprietary`.
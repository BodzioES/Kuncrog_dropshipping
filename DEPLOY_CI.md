# CI/CD — GitHub Actions → VPS (Kuncrog)

Po każdym `git push` na gałąź `master` GitHub automatycznie wdraża kod sklepu
na VPS i odświeża https://ecommerce-shop.kuncrog.com

Wysyłany jest **tylko kod aplikacji** (`kuncrog_app/`). Pliki infrastruktury
(`docker-compose.yml`, `Dockerfile`, `.env`, `deploy/`, `kuncrog_database.sql`)
zostają na VPS.

---

## 1. Wymagania na VPS (umiarkowanie jednorazowe)

1. Docker jest zainstalowany (patrz `DEPLOY.md`, krok 5).
2. Cały bundle leży w ścieżce `VPS_PATH` — np. `/web_shop/kuncrog` — i zawiera:
   `docker-compose.yml`, `Dockerfile`, `.env`, `kuncrog_database.sql`,
   `deploy/scripts/ci-deploy.sh`.
3. `.env` na serwerze jest uzupełniony (SMTP Gmail, `APP_KEY`, hasła bazy).
   Test maila: `sudo docker compose exec app php artisan tinker` →
   `Mail::raw('test', fn($m) => $m->to('twoj@email.com'));`
4. Certyfikat SSL wystawiony: `sudo bash deploy/scripts/setup-ssl.sh`
   (DNS subdomeny musi wcześniej wskazywać IP VPS).

## 2. Klucz SSH (robisz to TYLKO raz)

Na **swoim komputerze** (Windows PowerShell) wygeneruj parę kluczy:

```powershell
ssh-keygen -t ed25519 -C "github-actions" -f $env:USERPROFILE\.ssh\kuncrog_actions
```

Powstaną dwa pliki:
- `~/.ssh/kuncrog_actions` — klucz **prywatny** (NIGDY nie publikuj, idzie do sekretu GitHub)
- `~/.ssh/kuncrog_actions.pub` — klucz **publiczny** (trafia na VPS)

Dodaj klucz publiczny do VPS (na serwerze):

```bash
# na VPS, jako uzytkownik, ktorym bedzie logowal sie workflow (np. root):
mkdir -p ~/.ssh && chmod 700 ~/.ssh
echo "PELNA_TRESC_z_PLIKU_kuncrog_actions.pub" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

**UWAGA:** workflow odpala `sudo docker ...` — konto z `VPS_USER` musi mieć
sudo bez hasła (`NOPASSWD`), albo po prostu użyj `root`.

Sprawdź połączenie z komputera:
```powershell
ssh -i $env:USERPROFILE\.ssh\kuncrog_actions root@IP_TWOJEGO_VPS "echo OK"
```

## 3. Sekrety GitHub Actions

W GitHub: **repo → Settings → Secrets and variables → Actions → New repository secret**.

| Sekret | Wartość |
|---|---|
| `VPS_HOST` | IP lub domena VPS, np. `51.210.xx.xx` |
| `VPS_USER` | np. `root` |
| `VPS_SSH_KEY` | CAŁA zawartość pliku `kuncrog_actions` (klucz PRYWATNY) |
| `VPS_PATH` | ścieżka bundle'a, np. `/web_shop/kuncrog` |

## 4. Uruchomienie

- Push na `master` → workflow `Deploy do VPS` rusza sam.
- Możesz też odtworzyć ręcznie: **Actions → Deploy do VPS → Run workflow**.

Przebieg (pliki w `.github/workflows/deploy.yml`):
1. `rsync` kodu (bez `.env`, `vendor`, `node_modules`, `storage`) do `$VPS_PATH/kuncrog_app/`
2. SSH: `cd $VPS_PATH && bash deploy/scripts/ci-deploy.sh`
   → chown, `docker compose build app`, `up -d app`, czyszczenie cache Laravel.

> Kontener `app` po restarcie KOPIUJE najnowszy kod z obrazu do wolumenu
> `app_data` (zmiana w `deploy/docker/entrypoint.sh`) — dzięki temu nowy kod
> faktycznie trafia na stronę, a nie zostaje stary.

## 5. Problem

| Objaw | Przyczyna / sprawdź |
|---|---|
| Workflow czerwony na kroku rsync | zły `VPS_HOST`/`VPS_USER`; klucz prywatny nie sparowany z publicznym |
| sudo: a password is required | konto `VPS_USER` musi mieć sudo bez hasła (lub użyj `root`) |
| Stary kod po deployu | nie zaktualizowany `deploy/docker/entrypoint.sh` na VPS (prześlij cały bundle jeszcze raz) |
| Błąd builda (npm/composer) | zobacz logi: `docker compose logs app` |
| Strona padła po deployu | `docker compose ps`; `.env` na VPS bez zmian — kod sync nie rusza `.env` |
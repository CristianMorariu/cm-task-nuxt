# TaskBox

Aplicație pentru managementul proiectelor și task-urilor, construită cu:

- **Backend:** Laravel 12 + Sanctum (API JSON)
- **Frontend:** Nuxt 3 (SPA) + Vue 3 + Tailwind CSS
- **Autentificare:** sesiune Laravel + Sanctum (stateful API)
- **Roluri:** `admin`, `manager`, `user` cu permisiuni diferite

---

## 1. Cerințe de sistem

- PHP **8.2+**
- Composer **2+**
- Node.js **18+** (sau versiune LTS curentă)
- NPM / PNPM / Yarn (exemplele de mai jos folosesc `npm`)
- MySQL / MariaDB (sau alt DB suportat de Laravel)

---

## 2. Instalare

Clonează repository-ul:

```bash
git clone https://github.com/CristianMorariu/cm-task-nuxt.git
cd <folder-proiect>

2.1. Backend (Laravel)

cd backend

# 1. Dependențe
composer install

# 2. .env
cp .env.example .env

# 3. Cheie aplicație
php artisan key:generate

# 4. Migrare + seed (dev)
php artisan migrate:fresh --seed

# 5. Link pentru fișiere (avataruri, poze etc.)
php artisan storage:link

# 6. Rulează serverul dev
php artisan serve

2.2. Frontend (Nuxt 3)

cd frontend

# Instalează dependențele JS
npm install

În .env (sau .env.local pentru Nuxt), setează URL-ul API:
VITE_API_BASE_URL="http://localhost:8000"
```

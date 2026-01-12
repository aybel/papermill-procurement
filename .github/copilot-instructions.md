# Copilot Instructions for papermill-procurement

## Overview
This is a monorepo for a procurement management system, split into two main components:
- **backend/**: Laravel 12 (PHP 8.2) API, using JWT Auth and Spatie Permissions
- **frontend/**: Vue 3 + Vite + TypeScript SPA

## Architecture & Data Flow
- **API**: All business logic and data access are in the backend. The API is versioned under `/api/v1/`.
- **Frontend**: Consumes the backend API via Axios. All supplier management, roles, and permissions are handled through API endpoints.
- **Auth**: JWT-based authentication. Most API routes require a valid token and permission checks (see `routes/api.php`).
- **CORS**: Configured in `backend/config/cors.php` (default: all origins allowed, but check for middleware issues if CORS errors occur).

## Key Workflows
- **Backend**
  - Install: `composer install` (see `composer.json`)
  - Setup: `php artisan migrate --seed` (for DB)
  - Run: `php artisan serve` (or via Docker Compose)
  - Test: `php artisan test` or `vendor/bin/phpunit`
- **Frontend**
  - Install: `npm install` in `frontend/`
  - Dev: `npm run dev`
  - Build: `npm run build`

## Project Conventions
- **API Versioning**: All endpoints are under `/api/v1/`.
- **Permissions**: Use Spatie's `permission` middleware for route protection (see `routes/api.php`).
- **Repositories**: Business logic is abstracted in `app/Repositories/`.
- **Service Providers**: Custom bindings in `app/Providers/RepositoryServiceProvider.php`.
- **Frontend State**: Uses Pinia for state management.
- **Styling**: Tailwind CSS (see `frontend/` config).

## Integration & Troubleshooting
- **CORS**: If you see CORS errors, ensure `\Fruitcake\Cors\HandleCors::class` is in the global middleware (see `app/Http/Kernel.php`).
- **Docker**: Use `docker-compose up` to run full stack locally. Configs in `docker/`.
- **.env**: Copy `.env.example` to `.env` in both backend and frontend, then adjust as needed.

## Key Files & Directories
- `backend/routes/api.php`: API endpoints and middleware
- `backend/app/Repositories/`: Business logic
- `backend/config/cors.php`: CORS settings
- `frontend/src/`: Vue app source
- `docker/`: Container configs

## Example: Protecting an API Route
```php
Route::middleware('permission:suppliers.view_any')->get('/suppliers', [SupplierController::class, 'index']);
```

---
For more details, see the `README.md` files in each subproject.

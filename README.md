# Papermill Procurement

Sistema de gestion de compras para una empresa papelera. El backend esta construido con Laravel y se ejecuta en un entorno Docker con Nginx, PHP, MySQL, Redis y MailHog.

## Descripcion

Este proyecto centraliza el flujo de compras y abastecimiento:

- Gestion de proveedores y contactos
- Catalogo de materiales
- Solicitudes de compra y seguimiento
- Control de estados y aprobaciones
- Gestion de usuarios, roles y permisos

## Stack tecnologico

- Backend: Laravel 12 sobre PHP 8.4 FPM Alpine
- Base de datos: MySQL 8.4
- Cache/colas: Redis 7.4 Alpine
- Web server: Nginx 1.27 Alpine
- Entorno local: Docker Compose
- Correo local: MailHog (latest)

Versiones tomadas de la configuracion actual en docker-compose y Dockerfile.

## Requisitos previos

- Docker Engine o Docker Desktop
- Docker Compose
- Git
- PowerShell (Windows) o Bash (Linux/macOS)

## Inicio rapido

1. Clona el repositorio.

```bash
git clone <repository-url>
cd papermill-procurement
```

2. Levanta los servicios.

```bash
docker compose up -d --build
```

3. Configura Laravel dentro del contenedor `papermill-php`.

```bash
docker exec -it papermill-php bash
composer install
cp .env.example .env
php artisan key:generate --force
php artisan jwt:secret --force
php artisan migrate --seed
exit
```

4. Verifica estado.

```bash
docker compose ps
```

Aplicacion disponible en `http://localhost:8088`.

## Servicios y puertos

| Servicio | Contenedor | Puerto host | Puerto contenedor |
| --- | --- | --- | --- |
| Nginx | `papermill-nginx` | 8088 | 80 |
| MySQL | `papermill-mysql` | 3307 | 3306 |
| Redis | `papermill-redis` | 6381 | 6379 |
| MailHog UI | `papermill-mailhog` | 8025 | 8025 |
| MailHog SMTP | `papermill-mailhog` | 1025 | 1025 |

## Variables de entorno base

Crear `backend/.env` (si no existe) con base en `backend/.env.example`.

Valores comunes en local:

```env
APP_NAME="Papermill Procurement"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8088
APP_TIMEZONE=America/Mexico_City

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=papermill_db
DB_USERNAME=papermill_user
DB_PASSWORD=papermill_pass

REDIS_HOST=redis
REDIS_PORT=6379

JWT_SECRET=
```

## Comandos utiles

### Docker

```bash
# levantar servicios
docker compose up -d

# detener servicios
docker compose down

# reconstruir imagenes
docker compose up -d --build

# logs
docker compose logs -f
```

### Laravel (desde host)

```bash
# correr pruebas
docker exec -it papermill-php php artisan test

# limpiar caches
docker exec -it papermill-php php artisan optimize:clear

# migraciones
docker exec -it papermill-php php artisan migrate

# seeders
docker exec -it papermill-php php artisan db:seed
```

## Scripts PowerShell

El repositorio incluye:

- `start.ps1`: arranque rapido de servicios
- `manage.ps1`: tareas de gestion del proyecto

Uso:

```powershell
.\start.ps1
.\manage.ps1
```

## Arquitectura (resumen)

El proyecto usa un enfoque de monolito modular en Laravel con evolucion progresiva hacia DDD + Hexagonal en modulos nuevos.

- Legacy (MVC): `backend/app/Http`, `backend/app/Models`, `backend/app/Services`
- Nuevos modulos: `backend/app/Modules/<Modulo>/{Domain,Application,Infrastructure}`

Documentacion adicional:

- `guia_DDD.html`
- `FILTROS.md`
- `backend/DEPARTAMENTOS_Y_ACCESO.md`
- `backend/API_ROLES_PERMISOS.md`

## Troubleshooting rapido

### Docker en Linux sin permisos

Si aparece `permission denied` al usar Docker:

```bash
sudo systemctl start docker
sudo usermod -aG docker $USER
newgrp docker
```

Luego vuelve a ejecutar `docker compose up -d --build`.

### Error 403 por cache/rutas/permisos

```bash
docker exec -it papermill-php php artisan config:clear
docker exec -it papermill-php php artisan cache:clear
docker exec -it papermill-php php artisan route:clear
docker exec -it papermill-php php artisan optimize:clear
docker exec -it papermill-php php artisan permission:cache-reset
docker restart papermill-php
```

## Notas

- Timezone local esperada: `America/Mexico_City`
- Para desarrollo se recomienda trabajar siempre con Docker para evitar diferencias de entorno

## Configuracion tecnica actual

### PHP (contenedor papermill-php)

- Imagen base: php:8.4-fpm-alpine
- Extensiones instaladas: gd, pdo_mysql, mbstring, exif, pcntl, bcmath, opcache
- Parametros PHP:
	- memory_limit=256M
	- upload_max_filesize=100M
	- post_max_size=100M
	- max_execution_time=300
	- date.timezone=America/Mexico_City

### MySQL (my.cnf)

- Charset/collation: utf8mb4 / utf8mb4_unicode_ci
- SQL mode: STRICT_TRANS_TABLES, NO_ZERO_IN_DATE, NO_ZERO_DATE, ERROR_FOR_DIVISION_BY_ZERO, NO_ENGINE_SUBSTITUTION
- Timezone: America/Mexico_City
- InnoDB buffer pool: 512M
- max_allowed_packet: 256M
- max_connections: 150
- Slow query log: habilitado (long_query_time=2)
- Seguridad: local_infile=0, symbolic-links=0

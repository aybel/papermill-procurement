# Papermill Procurement System

Sistema de gestión de compras para empresa papelera. Una aplicación web completa diseñada para administrar el proceso de adquisiciones, proveedores, órdenes de compra y control de inventario en la industria papelera.

## 📋 Descripción

Papermill Procurement es una solución integral para la gestión de compras y aprovisionamiento en empresas del sector papelero. El sistema permite:

- Gestión de proveedores y catálogos de productos
- Creación y seguimiento de órdenes de compra
- Control de inventario y stock
- Aprobación de requisiciones
- Reportes y análisis de compras
- Gestión de usuarios y permisos

## 🚀 Tecnologías

### Backend
- **Laravel 12** - Framework PHP
- **PHP 8.4** - Lenguaje de programación
- **MySQL 8.0** - Base de datos
- **Redis 7** - Caché y colas

### DevOps
- **Docker & Docker Compose** - Contenedorización
- **Nginx** - Servidor web
- **Supervisor** - Gestor de procesos

## 📦 Requisitos Previos

- Docker Desktop instalado
- Git
- PowerShell (para Windows)

## ⚙️ Instalación

### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd papermill-procurement
```

### 2. Levantar los servicios con Docker

```bash
docker compose up -d --build
```

Si estás en Linux y aparece este error:

`permission denied while trying to connect to the docker API at unix:///var/run/docker.sock`

ejecuta:

```bash
sudo systemctl start docker
sudo usermod -aG docker $USER
newgrp docker
```

y vuelve a correr `docker compose up -d --build`.

Esto iniciará los siguientes servicios:
- **Nginx** en `http://localhost:8088`
- **MySQL** en puerto `3307`
- **Redis** en puerto `6381`
- **PHP-FPM** para el backend Laravel

### 3. Configurar el backend

```bash
# Acceder al contenedor PHP
docker exec -it papermill-php bash

# Dentro del contenedor
composer install
cp .env.example .env
php artisan key:generate --force
php artisan jwt:secret --force
php artisan migrate
php artisan db:seed
```

Si `php artisan key:generate --force` falla con `No APP_KEY variable was found in the .env file`, agrega antes esta linea en `backend/.env`:

```env
APP_KEY=
```

Si aparece `SecretMissingException` de JWT, verifica que exista esta variable en `backend/.env` y luego vuelve a ejecutar `php artisan jwt:secret --force`:

```env
JWT_SECRET=
```

## 🎮 Scripts de PowerShell

El proyecto incluye scripts de PowerShell para facilitar la gestión:

### `start.ps1`
Inicia todos los servicios Docker

```powershell
.\start.ps1
```

### `manage.ps1`
Script de gestión general del proyecto

```powershell
.\manage.ps1
```

## 🔧 Configuración

### Variables de Entorno

Crear un archivo `.env` en el directorio `backend/` con las siguientes configuraciones:

```env
APP_NAME="Papermill Procurement"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8088

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

### Puertos

| Servicio | Puerto Host | Puerto Contenedor |
|----------|-------------|-------------------|
| Nginx    | 8088        | 80                |
| MySQL    | 3307        | 3306              |
| Redis    | 6381        | 6379              |

## 📂 Estructura del Proyecto

```
papermill-procurement/
├── backend/              # Aplicación Laravel
│   ├── app/             # Código de la aplicación
│   ├── config/          # Archivos de configuración
│   ├── database/        # Migraciones y seeders
│   ├── public/          # Archivos públicos
│   ├── resources/       # Vistas y assets
│   ├── routes/          # Definición de rutas
│   └── tests/           # Tests automatizados
├── docker/              # Configuraciones Docker
│   ├── nginx/          # Configuración Nginx
│   ├── php/            # Dockerfile y configuración PHP
│   └── mysql/          # Configuración MySQL
├── docker-compose.yaml  # Orquestación de servicios
├── start.ps1           # Script de inicio
└── manage.ps1          # Script de gestión
```

## 🧪 Testing

Ejecutar los tests del backend:

```bash
docker exec -it papermill-php bash
php artisan test
```

## 📊 Base de Datos

El sistema utiliza MySQL 8.0 con las siguientes características:

- **Base de datos**: `papermill_db`
- **Usuario**: `papermill_user`
- **Contraseña**: `papermill_pass`
- **Puerto externo**: `3307`

### Estructura de Tablas

El sistema cuenta con 11 tablas principales más una vista:

**Catálogos:**
- **supplier_types**: Tipos de proveedores (materia prima, empaque, químicos, servicios, equipamiento)
- **supplier_statuses**: Estados de proveedores (activo, suspendido, inactivo)

**Tablas principales:**
- **material_categories**: Categorías jerárquicas de materiales
- **suppliers**: Proveedores con métricas de desempeño
- **supplier_contacts**: Múltiples contactos por proveedor
- **materials**: Materiales con especificaciones para papel
- **purchase_requisitions**: Requisiciones de compra
- **purchase_orders**: Órdenes de compra
- **purchase_order_items**: Ítems de órdenes
- **receipts**: Recepción de materiales
- **quality_inspections**: Inspecciones de calidad específicas para papel
- **supplier_performance_daily**: Vista de KPIs de proveedores

### Migraciones

```bash
docker exec -it papermill-php php artisan migrate
```

### Seeders

```bash
docker exec -it papermill-php php artisan db:seed
```

## 🔐 Seguridad

- Cambiar las contraseñas por defecto en producción
- Configurar `APP_DEBUG=false` en producción
- Utilizar HTTPS en producción
- Configurar correctamente los CORS
- Revisar los permisos de archivos y directorios

## 🚀 Deployment

Para despliegue en producción:

1. Configurar variables de entorno de producción
2. Ejecutar optimizaciones de Laravel:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. Compilar assets para producción
4. Configurar SSL/TLS
5. Configurar backups automáticos de la base de datos

## 🤝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT.

## 👥 Autores

- **Tu Nombre** - *Jesus Abel Vera*

## 📞 Soporte 0000.00000.00000

Para soporte y preguntas, por favor crear un issue en el repositorio.

---

Desarrollado con ❤️ para el departamento de compras

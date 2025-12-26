#!/bin/bash
set -e

echo "🚀 Configurando Laravel 11 con PHP 8.4..."

# Verificar si Laravel está instalado
if [ ! -f "composer.json" ]; then
    echo "📦 Instalando Laravel 11..."
    composer create-project laravel/laravel . --prefer-dist --no-interaction
fi

# Instalar dependencias
echo "📦 Instalando dependencias PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generar key si no existe
if grep -q "APP_KEY=" .env 2>/dev/null && ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "🔑 Generando APP_KEY..."
    php artisan key:generate --force
fi

# Configurar cache
echo "⚡ Optimizando Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Configurar permisos
echo "🔒 Configurando permisos..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Ejecutar migraciones
echo "🗄️ Ejecutando migraciones..."
php artisan migrate --force

# Instalar dependencias NPM si existe package.json
if [ -f "package.json" ]; then
    echo "📦 Instalando dependencias Node.js..."
    npm install --no-audit --prefer-offline
fi

echo "✅ Laravel 11 configurado correctamente!"
echo "🌐 Accede en: http://localhost:8088"

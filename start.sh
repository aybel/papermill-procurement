#!/usr/bin/env bash
set -e

echo "========================================"
echo "  PAPERMILL PROCUREMENT SYSTEM"
echo "========================================"

BACKEND_URL="http://localhost:8088"
FRONTEND_URL="http://localhost:5174"
PHP_SERVICE="php"

# 1. Levantar contenedores
echo ""
echo "1. Iniciando contenedores..."
docker compose up -d

# 2. Inicializar storage (idempotente, solo hace trabajo la 1ª vez)
echo "2. Inicializando estructura de storage..."
docker compose exec -T "$PHP_SERVICE" sh -c "
mkdir -p storage/logs \
         storage/framework/cache \
         storage/framework/sessions \
         storage/framework/views \
         storage/app/public \
         bootstrap/cache &&
chown -R www-data:www-data storage bootstrap/cache &&
chmod -R 775 storage bootstrap/cache
"

# 3. Esperar a que MySQL y PHP estén healthy
echo "3. Esperando servicios saludables..."
for i in {1..30}; do
    UNHEALTHY=$(docker compose ps --format json | grep -c '"Health":"starting"' || true)
    if [ "$UNHEALTHY" -eq 0 ]; then
        break
    fi
    printf "."
    sleep 2
done
echo ""

# 4. Estado
echo "4. Estado de los contenedores:"
docker compose ps

# 5. Abrir navegadores
echo ""
echo "5. Abriendo aplicaciones..."
xdg-open "$BACKEND_URL" 2>/dev/null || echo "Abre manualmente: $BACKEND_URL"
xdg-open "$FRONTEND_URL" 2>/dev/null || echo "Abre manualmente: $FRONTEND_URL"

# 6. Info final
echo ""
echo "✅ SISTEMA LISTO"
echo "Backend:  $BACKEND_URL"
echo "Frontend: $FRONTEND_URL"
echo ""
echo "Comandos útiles:"
echo "• Logs PHP:     docker compose logs -f php"
echo "• Artisan:      docker compose exec php php artisan"
echo "• Tinker:       docker compose exec php php artisan tinker"
echo "• MySQL:        docker compose exec mysql mysql -u papermill_user -p"

#7 log
docker compose exec php tail -f storage/logs/laravel.log
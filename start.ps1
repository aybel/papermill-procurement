# Papermill Procurement - Startup Script
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  PAPERMILL PROCUREMENT SYSTEM" -ForegroundColor White -BackgroundColor DarkBlue
Write-Host "========================================" -ForegroundColor Cyan

# Variables
$backendUrl = "http://localhost:8088"
$frontendUrl = "http://localhost:5174"

# 1. Iniciar Docker
Write-Host "`n1. Iniciando contenedores..." -ForegroundColor Yellow
docker-compose up -d

# 2. Esperar inicialización
Write-Host "2. Esperando servicios (30 segundos)..." -ForegroundColor Gray
for ($i = 1; $i -le 30; $i++) {
    Write-Host "." -NoNewline -ForegroundColor DarkGray
    Start-Sleep -Seconds 1
}
Write-Host "`n"

# 3. Verificar servicios
Write-Host "3. Verificando servicios..." -ForegroundColor Green
docker-compose ps

# 4. Abrir navegadores
Write-Host "4. Abriendo aplicaciones..." -ForegroundColor Magenta
Start-Process $backendUrl
Start-Process $frontendUrl

# 5. Mostrar información
Write-Host "`n✅ SISTEMA LISTO" -ForegroundColor White -BackgroundColor Green
Write-Host "Backend:  $backendUrl" -ForegroundColor Cyan
Write-Host "Frontend: $frontendUrl" -ForegroundColor Cyan
Write-Host "`nComandos útiles:" -ForegroundColor Yellow
Write-Host "• Ver logs: docker-compose logs -f" -ForegroundColor Gray
Write-Host "• Artisan: docker-compose exec php php artisan" -ForegroundColor Gray
Write-Host "• Tinker: docker-compose exec php php artisan tinker" -ForegroundColor Gray
Write-Host "• MySQL: docker-compose exec mysql mysql -u papermill_user -p" -ForegroundColor Gray

param(
    [Parameter(Mandatory=$false)]
    [ValidateSet("start", "stop", "restart", "logs", "artisan", "tinker", "mysql", "redis", "status", "update")]
    [string]$Action = "status"
)

switch ($Action) {
    "start" {
        docker-compose up -d
        Start-Sleep -Seconds 10
        docker-compose ps
        Start-Process "http://localhost:8088"
        Start-Process "http://localhost:5174"
    }
    
    "stop" {
        docker-compose down
    }
    
    "restart" {
        docker-compose restart
        Start-Sleep -Seconds 5
        docker-compose ps
    }
    
    "logs" {
        docker-compose logs -f
    }
    
    "artisan" {
        docker-compose exec php php artisan $args
    }
    
    "tinker" {
        docker-compose exec php php artisan tinker
    }
    
    "mysql" {
        docker-compose exec mysql mysql -u papermill_user -p pape
    }
    
    "redis" {
        docker-compose exec redis redis-cli
    }
    
    "status" {
        docker-compose ps
        Write-Host "`nURLs:" -ForegroundColor Green
        Write-Host "• Backend:  http://localhost:8088" -ForegroundColor Cyan
        Write-Host "• Frontend: http://localhost:5174" -ForegroundColor Cyan
    }
    
    "update" {
        docker-compose down
        docker-compose build --no-cache
        docker-compose up -d
        Start-Sleep -Seconds 15
        docker-compose ps
    }
}

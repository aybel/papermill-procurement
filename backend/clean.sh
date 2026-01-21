# artisan commands to clear caches and optimize the application
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
php artisan octane:reload

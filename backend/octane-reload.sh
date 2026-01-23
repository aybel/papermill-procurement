#!/bin/bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
php artisan octane:reload

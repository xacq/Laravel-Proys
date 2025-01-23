@echo off
cd C:\proy3
php artisan schedule:run
php artisan report:generate

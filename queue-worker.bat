@echo off
title Laravel Queue Worker (PostgreSQL)
cd C:\Users\Marchell Manurung\xampp\htdocs\pifacia

:: Pastikan PostgreSQL berjalan sebelum menjalankan queue worker
echo Memeriksa koneksi ke PostgreSQL...
php artisan db:monitor

:: Jika koneksi berhasil, jalankan queue worker
IF %ERRORLEVEL% EQU 0 (
    echo Koneksi ke PostgreSQL berhasil, menjalankan queue worker...
    php artisan queue:work --sleep=3 --tries=3 --max-time=3600
) ELSE (
    echo Koneksi ke PostgreSQL gagal. Pastikan PostgreSQL berjalan.
    pause
)
#!/bin/sh
php artisan migrate:refresh  --seed
php artisan import:products

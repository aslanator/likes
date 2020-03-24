#!/bin/bash

docker exec php-fpm-likes php artisan migrate:rollback --step=$1 -n

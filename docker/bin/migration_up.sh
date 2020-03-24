#!/bin/bash

docker exec php-fpm-likes php artisan migrate -n

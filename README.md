Установка  
Создать файл .env и скопировать туда все из .env.example  
Запустить docker-compose  
Выполнить комманды:  
./docker/bin/composer.sh install  
./docker/bin/migration_up.sh   
./docker/bin/seed.sh   
./docker/bin/passport.sh     


По умолчанию программа запускается на localhost:8090  (порт меняется в env)
Логин: test@test.com Пароль: secret

Для зяпуска выполнить
```
git clone
docker-compose up --build -d
docker-compose php composer install
docker-compose php php artisan migrate:fresh --seed
```

потом перейти http://localhost:8080

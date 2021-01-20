Для зяпуска выполнить
```
git clone
docker-compose up --build -d
docker-compose php composer install
docker-compose php php artisan migrate:fresh --seed
npm install && npm dev
```

потом перейти http://localhost:8080

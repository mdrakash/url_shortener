## Installation
```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

```

## Make Admin User
```
php artisan make:admin
```

## API Use
Login to `POST /api/login`
Copy Token
Retrive Data to `GET /api/list` using bearer token
Store Data to `POST /api/store` using bearer token

## Installation
```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan serve

```

## Make Admin User
```
php artisan make:admin
```

## API Use

```
1 Login to
    url:/api/login
    method:POST
    params:body:formdata
        email:examplemail@email.com
        password:protected
2 Copy Token
3 Retrive Data to `GET /api/list` using bearer token
4 Store Data to using bearer token 
    url:/api/store
    method:POST
    params:body:formdata
        url:https://example.com/
        code:example(optional)
        expires_at:2022-11-08 11:49(optional)
```
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

## Web Use
1. If you are free user you can random generate short code for url and expire     will be 1 day
2. If you login as a user you can extra feature for url shortener like custom short code and set expire date and you can multiple url short.
    to see your all link shortener go 
    ```
    http://example.com/list
    ```
3. You can also edit and delete Short Link and also show link click count.
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
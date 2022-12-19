<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>
<h1 align="center">Cổng đánh giá năng lực sinh viên FPoly</h1>
<p >Create folder tmp </p>

```shc
    $ sudo mkdir tmp
    $ sudo chmod -R 755 path/tmp
```
<p >Run migrate </p>

```sh
    $ php artisan migrate
```
<p >Install pakage </p>

```sh
    $ composer install --no-dev
``` 
```sh
    $ npm install
```
<p >Setup laravel echo server port 6001</p>
 
- Make sure you have `redis` install on your computer. Try run `redis-cli` in terminal to see
- Make sure you run `redis-server`
- Check if you have `laravel-echo-server` installed, otherwise install it by running `npm install laravel-echo-server`
 

```sh
    $ laravel-echo-server init
``` 

<p >Build image docker </p>

```sh
    $ docker build -t capacity_gcc -f ./docker/gcc/Dockerfile .
    $ docker build -t capacity_java -f ./docker/java/Dockerfile .
    $ docker build -t capacity_javascript -f ./docker/javascript/Dockerfile .
    $ docker build -t capacity_php -f ./docker/php/Dockerfile .
    $ docker build -t capacity_py -f ./docker/python/Dockerfile .
```

Before start the project, open `.env`, and update the following:
- `BROADCAST_DRIVER` change to `redis` 
- `CACHE_DRIVER` change to `redis` 
- `QUEUE_CONNECTION` change to `redis` 
- `SESSION_DRIVER` change to `redis` 
- `REDIS_HOST` change to host 
- `REDIS_PASSWORD` change to password 
- `REDIS_CLIENT=predis`

- `APP_DEBUG=false` 
- Key `AWS`,`Google`,`Mailer`


Start the project:
```
php artisan server
php artisan queue:work --queue=default
php artisan schedule:work
laravel-echo-server start 
```
  

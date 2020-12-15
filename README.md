STEPS to set up:

1.  clone repository
2.  composer install
3.  cp .env.example .env
4.  set up necessary .env config (e.g. database)
5.  php artisan key:generate
6.  php artisan migrate
7.  php artisan passport:install
8.  php artisan serve

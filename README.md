STEPS to set up:

1.  clone repository
2.  composer install
3.  cp .env.example .env
4.  set up necessary .env config (e.g. database)
5.  php artisan key:generate
6.  php artisan migrate
7.  php artisan passport:install
8.  php artisan serve
9.  Example CURL scripts to test api auth

-- SIGN UP

curl --location --request POST 'http://127.0.0.1:8000/api/auth/signup' 
--header 'Content-Type: application/json' 
--header 'X-Requested-With: XMLHttpRequest' 
--data-raw '{
	"name": "bok",
	"email": "bok@test.com",
	"password": "test12345",
	"password_confirmation": "test12345"
}'


-- LOG IN

curl --location --request POST 'http://127.0.0.1:8000/api/auth/login' 
--header 'Content-Type: application/json' 
--header 'X-Requested-With: XMLHttpRequest' 
--data-raw '{
	"email": "bok@test.com",
	"password": "test12345"
}'


-- USER INFO

curl --location --request GET 'http://127.0.0.1:8000/api/auth/user' 
--header 'Authorization: Bearer <token>'


-- LOG OUT

curl --location --request GET 'http://127.0.0.1:8000/api/auth/logout' 
--header 'Authorization: Bearer <token>'

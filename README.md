# Notes

REST api, Laravel, used in [Notes app](https://github.com/vladimirbalin/vue-notes).
## Installation and deployment

1. Clone repo and install all dependencies:

```
composer install
```
Make sure you created .env
```
cp .env.example .env
```
with properties set with link to Notes application
```
SESSION_DOMAIN=
SANCTUM_STATEFUL_DOMAINS=
```
Dont forget to `php artisan key:generate`

2. Create database and set correspond properties in .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=notes
DB_USERNAME=
DB_PASSWORD=
```
3. Populate db with migrations and seeds:
 ```
php artisan migrate --seed
 ```


### Features and instruments used

- Login and registration, logout
- Adding new, updating and deleting notes


## Tech stack used

- Laravel
- [PHPFaker](https://github.com/FakerPHP/Faker) for seeds

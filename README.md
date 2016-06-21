# Slim 3 REST Skeleton

This is a simple skeleton project for Slim 3 that implements a simple REST API.
Based on [akrabat's slim3-skeleton](https://github.com/akrabat/slim3-skeleton).

This branch also implements [Eloquent](https://laravel.com/docs/5.2/eloquent) and [Phinx](https://phinx.org/).

## Create Database

Add database settings to app/settings.php.

run:
```
vendor/bin/phinx migrate
vendor/bin/phinx seed:run
```

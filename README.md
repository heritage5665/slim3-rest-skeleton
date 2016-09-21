# Slim 3 REST Skeleton

This is a simple skeleton project for Slim 3 that implements a simple REST API.
Based on [akrabat's slim3-skeleton](https://github.com/akrabat/slim3-skeleton).

The master branch also uses [Eloquent](https://laravel.com/docs/5.2/eloquent) and [Phinx](https://phinx.org/).
If you are looking for a minimal skeleton only using Slim 3, checkout the minimal branch.

## Create Database

Add database settings to app/settings.php.

run:
```
vendor/bin/phinx migrate
vendor/bin/phinx seed:run
```

## Testing

Unit tests are set up for this skeleton. Take a look in the `tests` directory.
There are tests for all Actions.

Instead of mocking the database, a separate testing database is configured.
The testing database configuration is set in `app/settings.php` right next to
the normal database. For every test case the testing database will be reset by
rollback, migrate and seed with phinx automatically. Seeding the testing
database is done by a separate seed defined in `db/seeds_testing`. So there
can be more or different dummy data, than in the normal seed for the
development (or production) database in `db/seeds`.

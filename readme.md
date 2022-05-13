# Get started

### 1. Set database access in ``.env`` file

### 2. Install dependencies

```
$ composer install
$ yarn install
```

### 3. Build login react apps

```
$ yarn build
```

### 4. Install and deploy database

```
$ php bin/console doctrine:database:create
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
$ php bin/console app:fixtures
```

### 5. Start php dev server

```
$ symfony server:start
```

### 6. Enjoy !

Login at http://localhost:8000

**Default test user (injected in fixtures) is : test@example // test**

Then access API swagger page at http://localhost:8000/api


# Usefull commands

### Make or edit and entity
php bin/console make:entity --api-resource

### Generate migration file based on entities
php bin/console make:migration

### Applying migrations on database
php bin/console doctrine:migrations:migrate

### Drop database
php bin/console doctrine:database:drop --force

### Create database
php bin/console doctrine:database:create

### Load fixture (!!! purge database)
php bin/console doctrine:fixtures:load

### Clear cache
php bin/console cache:clear

### Start PHP dev server
php -S localhost:8000 -t public public/index.php
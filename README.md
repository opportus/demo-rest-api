Demo Symfony 4 REST API using HAL as hypermedia format standard.

## Installation

### Step 1 - Clone And Compose The Application

Clone the repository:
```shell
git clone https://github.com/opportus/demo-rest-api.git path/to/my/project
```

Change the working directory:
```shell
cd path/to/my/project
```

Install dependencies:
```shell
composer install
```

### Step 2 - Configure The Application

Configure Doctrine:

https://symfony.com/doc/current/doctrine.html#configuring-the-database

### Step 3 - Load Intitial Data To The Application Database

Create the database:
```shell
php bin/console doctrine:database:create
```

Create the database schema:
```shell
php bin/console doctrine:schema:create
```

Load fixtures:
```shell
php bin/console doctrine:fixtures:load
```

# cogitech-int
Coding job interview solution for Cogitech group

### Setup ###

Clone this repository

```bash
git clone https://github.com/adreline/cogitech-int.git
```
Install the app

```bash
composer install
```

### Usage ###

Download post data and store it in a local sqlite database

```bash
php bin/console app:pull-posts
```

Start the test server

```bash
composer require --dev symfony/web-server-bundle
php bin/console server:start
```

Open the web interface [127.0.0.1:8000/](http://127.0.0.1:8000/)

### Requirements ###

- PHP ^8.1
- Composer ^2.5.0



# 1. Technology
- PHP 8.1
- Laravel Framework 9.x

# 2. Configuration requirements
- Install composer: https://getcomposer.org/

# 3. Running

## Clone repo

```bash
git clone https://github.com/tanhongit/sms-authentication-laravel
cd sms-authentication-laravel
```

## Install Composer & npm for project

Run:

```bash
npm install
composer install
```

## Create APP_KEY

Run:

```
cp .env.example .env
php artisan key:generate
```

## Create twilio account & get account SID & auth token in the .env file

```laravel
TWILIO_SID=XXXXXXXXXXXXXXXXX
TWILIO_TOKEN=XXXXXXXXXXXXXXX
TWILIO_FROM=+XXXXXXXXX
```

## Create a new database in your host & edit .env

Create a new database in your server and edit the information in the .env file

```laravel
DB_CONNECTION=mysql
DB_HOST=172.24.0.2
DB_PORT=3306
DB_DATABASE=sms-authentication-laravel
DB_USERNAME=root
DB_PASSWORD=root
```

> Don't forget to change __APP_URL__ on *.env* file for your app.

## Migrate Database

Run:

```bash
php artisan migrate
```

## Launch project
Now, Launch your system...

Run:

```bash
npm run dev
```

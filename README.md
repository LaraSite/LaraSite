# LaraSite
Simple CMS on Laravel framework

## # Requirements
- PHP >= 5.5.9
- Database
 - SQLite
 - MySQL
 - PostgreSQL

## # Instration
```
$ composer create-project larasite/larasite path/to/install
$ cd path/to/install
$ composer install
```

## # Configration

 .env
```
# ...

APP_DEBUG=false

# ...

# database
DB_CONNECTION=mysql
DB_HOST=YOUR_DB_HOST
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USERNAME
DB_PASSWORD=YOUR_PASSWORD

# ...

# Mail
MAIL_DRIVER=smtp
MAIL_HOST=YOUR_SMTP_HOST
MAIL_PORT=YOUR_SMTP_PORT
MAIL_USERNAME=YOUR_MAIL_USERID
MAIL_PASSWORD=YOUR_MAIL_PASSWORD
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=sender@email.com
MAIL_FROM_NAME=SENDER_NAME

# MailForm
MAILFORM_DELIVERY_ADDRESS=admin@email.com
MAILFORM_DELIVERY_NAME=ADMIN_NAME
```

config/app.php
```
'url' => 'http://your_host_name',
'timezone' => 'Asia/Tokyo',
'locale' => 'ja',
```

## Setup Database
SQLite.
```
$ touch strage/database.sqlite
```

```
$ php artisan migrate
```

## Run LaraSite
```
$ php artisan serve
Laravel development server started on http://localhost:8000/
```

## Customize

You can customeize a LaraSite in the Laravel way.
- Blade Template
- Eloquent ORM
- Etc.

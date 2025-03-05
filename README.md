# Laravel 12 Setup Instructions

This guide will walk you through the setup process for a Laravel 12 application running on PHP 8.3. Follow these steps to get started with the project.

## Prerequisites

- PHP 8.3 or higher
- Composer (for managing PHP dependencies)
- A database (MySQL, PostgreSQL, etc.)
- Laravel 12

## 1. Clone the Repository
```bash
git clone https://github.com/sowidan1/Lms.git
```
## 2. Copy the .env file

```bash
cp .env.example .env
```

## Prerequisites
- put variables needed in .env

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=ossowidan@gmail.com
MAIL_PASSWORD=haxkvkfxsatvqbnx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=ossowidan@gmail.com
MAIL_FROM_NAME=LMS

STRIPE_KEY=pk_test_51Qz2A6KzGTHIcKrhWUnfnF73x0cmtlJCFCKBvNLuA5LR5NypUrBySTh6lT1NrUOGZNRzdy9K3LXE423LNeGlXOvn00zMJd26kX
STRIPE_SECRET=sk_test_51Qz2A6KzGTHIcKrhOTs1D07TnGWJnyDUNjghgGMPDrNn7idYP47VOi3WfME4jAsAUAPk4y4AnZv7zR1HfIpN6s1300nDDfQzdM
STRIPE_WEBHOOK_SECRET=whsec_469542dc6de05111f8b71a4ff38e3c220ffef7eb0e3cfe205163929dc584c79d
```

## 3. Install Dependencies
```bash
composer install
```
## 4. Generate Application Key
```bash
php artisan key:generate
```

## 5. jwt
```bash
php artisan jwt:secret
```

## 6. Run Database Migrations
```bash
php artisan migrate
```

## 7. Run Database seeder
```bash
php artisan db:seed
```
## 7. postman collection
[Download the postman collection](LMS_postman_collection.json)


### If you are deploying the application to production, be sure to configure appropriate caching and optimize the application:
```bash
php artisan optimize:clear
```

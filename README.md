<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://user-images.githubusercontent.com/8923057/228454679-0df24e6e-1c8f-437a-ba7b-b48149fef1f1.svg" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Poldea Project Description

This repository contains the group student project for the coursework of our class. The project involves designing and implementing a software solution for a real-world web application., such as:

## Installation instructions
### Requirements
- PHP: 8.0
- MySQL: 5.2.0
- Composer

### Installation
- Make sure you have correct php setup. If you already have php enviroment, Skip `Xampp` Installation. 
- If you are not, we recommend to use `Xampp` to setup your php setup.

### Xampp Installation
- Download [Xampp](https://www.apachefriends.org/download.html) (PHP 8.0).
- Run Xampp Installer.

### Project Setup
- Create a database using MySQL.
- Extract Poldea_University_Project.zip to your php project folder. If you using `Xampp`, eg. xampp>htdocs>project_folder.
- Copy `.env.example` to `.env` in your project root.
- In `.env` file inside of your project root, You need to set
    - Application URL
    - Database Configuration
        ```php
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=your_database_name
            DB_USERNAME=your_database_user
            DB_PASSWORD=your_database_password
            ...
        ```
    - Mail Configuration
        ```php
            MAIL_MAILER=smtp
            MAIL_HOST=your_mail_host
            MAIL_PORT=your_mail_port
            MAIL_USERNAME=mail_username
            MAIL_PASSWORD=mail_password
            MAIL_ENCRYPTION="tls or ssl"
            MAIL_FROM_ADDRESS=mail_username
            ...
        ```
    - Admin Account Credentials
        ```php
            ADMIN_USERNAME=username
            ADMIN_PASSWORD=password
            ...
        ```
    - File Type Specifiy
        ```php
            FILE_TYPE="pdf,doc,docx"
            IMAGE_TYPE="jpg,jpeg,png"
            ...
        ```
- Open the console and `cd` your project root directory
- Run to Install Laravel Packages
```php
composer install
```
- Run to generate application encrypt key
```php
php artisan key:generate
```
- Run to setup database tables and columns structures
```php 
php artisan migrate
```
Or reset database
```php 
php artisan migrate:fresh
```
- Run to import system setup data (Note*: Don't forget to add Admin username and password in `.env` file)
```php 
php artisan db:seed
```
- After Email Configuration, To use Email Sending Process, need to run this command in terminal of your project root
```php
php artisan queue:work
```
- Run to Launch Poldea Project
```php 
php artisan serve
```
- You can now access your project at 
    - http://localhost:[port] eg. http://localhost:8000 (OR)
    - http://127.0.0.1:[port] eg. http://127.0.0.1:8000

## Contribution guidelines

Thank you for considering contributing to the Poldea project!

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

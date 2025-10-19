# Laravel 11 Booking System API

A RESTful API built with **Laravel 11** for managing a hotel booking system. This API currently supports **Rooms**, **Bookings**, and **Guests**. Designed for integration with a frontend dashboard or mobile application.  

**Progress:** 30% (Rooms, Bookings, Guests implemented)  

---

## Table of Contents

- [Features](#features)  
- [Installation](#installation)  
- [Environment Setup](#environment-setup)  
- [Database Setup](#database-setup)  
- [API Authentication (Passport)](#api-authentication-passport)  
- [CORS Setup](#cors-setup)  
- [Available Endpoints](#available-endpoints)  
- [Usage](#usage)  
- [Code Structure](#code-structure)  
- [Future Development](#future-development)  

---

## Features

- Manage **Rooms** with types, prices, capacity, and availability  
- Manage **Bookings** including status and guest assignment  
- Manage **Guests** profiles and contact information  
- Fully RESTful endpoints  
- API authentication with **Laravel Passport**  
- Cross-Origin Resource Sharing (**CORS**) support for frontend integration  

---

## Installation

1. **Clone the repository**  

```bash
git clone <your-repo-url>
cd laravel-booking-api
```

2. **Install Composer Dependencies**  

```bash
composer install
```

3. **Install NPM Dependencies(If needed for Front-end Assets)**  

```bash
npm install
npm run dev
```

4. **Copy .env file** 

```bash
cp .env.example .env
```

5. **Generate application key**

```bash
php artisan key:generate
```

## Environment Setup

Edit the .env file with your environment variables, including database credentials:

-   DB_CONNECTION=mysql
-   DB_HOST=127.0.0.1
-   DB_PORT=3306
-   DB_DATABASE=booking_system
-   DB_USERNAME=root
-   DB_PASSWORD=



## Database Setup


1. **Run migrations** 
```bash
php artisan migrate
```

2. **(Optional) Seed database** 
```bash
php artisan db:seed
```


## API Authentication (Laravel Passport)

1. **Install Passport** 
```bash
composer require laravel/passport
```

2. **Run Passport migrations** 
```bash
php artisan migrate
```

3. **Install encryption keys** 
```bash
php artisan passport:install
```

4. **Add Passport to AuthServiceProvider** 
```php
use Laravel\Passport\Passport;

public function boot()
{
    $this->registerPolicies();
    Passport::routes();
}
```

5. **Set API guard to passport in config/auth.php** 
```php
'guards' => [
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

6. **Use middleware in routes** 
```php
Route::middleware('auth:api')->group(function() {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });
});
```

## Available Endpoints

Available Endpoints

Currently implemented:

Method	         	 Endpoint                     Description
GET	   /api/rooms	                              List all rooms
GET	/api/rooms/{id}	                           Get room details
POST	/api/rooms	                                 Create a new room
PUT	/api/rooms/{id}	                           Update a room
DELETE	/api/rooms/{id}	                        Delete a room
GET	/api/bookings	                              List all bookings
GET	/api/bookings/{id}	                        Get booking details
POST	/api/bookings	                              Create a booking
PUT	/api/bookings/{id}	                        Update booking status
DELETE	/api/bookings/{id}	                     Cancel a booking
GET	/api/guests	                                 List all guests
POST	/api/guests	                                 Add a new guest

## Usage

- Use Postman or Insomnia to test API endpoints.
- Authenticate requests with Bearer token obtained from Passport login endpoint.

```http
Authorization: Bearer <token>
```





Trigger deployment to cPanel via
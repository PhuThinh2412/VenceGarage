<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About Demo

- This is the demo that I made for job application by myself, without any help from other persons.
- Demo is using Laravel 10 and PHP8.1 for developing.
- Demo has initial data when run command seeding data by artisan.

# VenceGarage
Stick to following step for installig project on your local:

- Install php 8.1
- Install lastest composer
- Edit .env file connect to your local database
- Run `composer install`
- Run `php artisan migrate`
- Run `php artisan db::seed`
- Run `php artisan serve`

# Database defination
| vehicles_type |
| :----   |
| id |
| type_name |
| created_at |
| updated_at |

| vehicles |
| :----   |
| id |
| license_plate |
| type |
| status |
| created_at |
| updated_at |

| parking_levels |
| :----   |
| id |
| name |
| capacity |
| created_at |
| updated_at |

| parking_spaces |
| :----   |
| id |
| level_id |
| name |
| status |
| created_at |
| updated_at |

| parking_space_vehicles|
| :----   |
| id |
| vehicle_id |
| parking_space_id |  
| created_at |
| updated_at |

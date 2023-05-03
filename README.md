<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

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
| :---:   |
| id |
| type_name |
| created_at |
| updated_at |

| vehicles |
| :---:   |
| id |
| license_plate |
| type |
| status |
| created_at |
| updated_at |

| parking_levels |
| :---:   |
| id |
| name |
| capacity |
| created_at |
| updated_at |

| parking_spaces |
| :---:   |
| id |
| level_id |
| name |
| status |
| created_at |
| updated_at |

| parking_space_vehicles|
| :---:   |
| id |
| vehicle_id |
| parking_space_id |  
| created_at |
| updated_at |
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://l  aravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.



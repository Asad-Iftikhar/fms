# fms
- Create a virtual host pointing to /public folder of your project.
- Create a database.
- Rename `.env.example` file to `.env` inside your project root and update the variables as needed.

Open the console and cd your project root directory and run following commands to install composer dependencies and setup the project

- Run `composer install`
- Run `php artisan key:generate` 
- Run `php artisan migrate` (Run `php artisan migrate:fresh` for fresh migrations)
- Run `php artisan db:seed`
- Run `php artisan passport:install`

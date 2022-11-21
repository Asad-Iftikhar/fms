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

## Cron Tab for Database backup
- Run following command in the terminal.
`crontab -e`
- Select the editor in order to add cronjob for example `'bin/nano/'`
- Add cron command `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1` in the file you just created using above mentioned step.
- Running The Scheduler Locally: This command will run in the foreground and invoke the scheduler according to what you set the conditions until you terminate the command: `php artisan schedule:work`

## Pusher:
- You can get the Pusher Channels PHP library via a composer package called pusher-php-server.`$ composer require pusher/pusher-php-server`
- Or add to `composer.json`:
`"require": {
    "pusher/pusher-php-server": "^7.2"
}`
- Make an account on Pusher https://pusher.com/.
- Use the credentials from your Pusher Channels application to create a new Pusher\Pusher instance.
```sh
Example:
app_id = "1504064"
key = "55c4f792919f9dc8b0fb"
secret = "a3506f210c79b3efebf9"
cluster = "ap2"
```
- Add these credentials in .env file. For Example
```sh
PUSHER_APP_ID=1504064
PUSHER_APP_KEY=55c4f792919f9dc8b0fb
PUSHER_APP_SECRET=a3506f210c79b3efebf9
PUSHER_APP_CLUSTER=ap2
```
There is another change in .env file and that is `BROADCAST_DRIVER`. Default it is set to `BROADCAST_DRIVER=log` just replace log with `BROADCAST_DRIVER=pusher`.

## Symbolic link for storage:
- Execute `php artisan storage:link` for creating symlink in laravel.

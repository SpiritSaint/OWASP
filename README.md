# PatchStack 

## Instructions

As every Laravel application you should do the following deployments steps:

1. Add composer dependencies with `composer install`.
2. Copy the `.env.example` to `.env`.
3. Configure your new `.env` with your local database settings.
4. Run `php artisan key:generate` to set the application encryption key.
5. Finally, you should run `php artisan serve`

## About the Web Scraper

I use [FriendsOfPHP/Goutte](https://github.com/FriendsOfPHP/Goutte) package to solve the data scrapping.

You can run `php artisan owasp:extract` in your terminal to retrieve the vulnerabilities from OWASP site.

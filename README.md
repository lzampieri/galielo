# Galielo

## Tools
- Laravel
- React

## Folder structure
Follow Laravel folder structure

Most useful folders are:
* `routes` directory, and in particular:
  * `web.php` which contains routes for webpages
  * `api.php` which contains routes for api
* `app` directory, and in particular:
  * `Models` directory, which contain list of models
* `database/migrations` which contains the info for table construction
* `resources/view` which contain php views
* `resources/js` which contains React file to be compiled
* `resources/sass` which should be explored

Most useful commands are:
* `php artisan migrate:refresh` to create table in the database
* `npm run watch` to compile js file from resources/js to public/js live during deploy
* `npm run prod` to compile js file from resources/js to public/js for the final publishing

### Warning
The directive `RewriteBase /public/` on the file `public/.htaccess` and the directive `URL::forceScheme('https');` in the file `app\Providers\AppServiceProvider.php` must be commented for local tests, but must be enabled for remote deploy.
### DEPLOY ###
* cd /var/www/html/tatrytect.eu
* git fetch origin
* git reset --hard master
* composer install --no-scripts --no-interaction
* npm install
* composer dump-autoload --optimize --no-dev
* chown -R www-data:www-data ./vendor/*
* npm run build
* chown -R www-data:ww-data ./node_modules/*


### MIDDLEWARE ###
Admin.php + Kernel.php + $routeMiddleware

### GITHUB WEBHOOK TEST ###
Github webhook + Jenkins Gihub plugin 5
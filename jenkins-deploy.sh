#!/bin/bash

www_dir=/var/www
tmp_dir=$www_dir/deploy-tmp
tmp_app_dir=$tmp_dir/tatrytec.eu
www_new_app_dir=$www_dir/deploy-new-tatrytec.eu
www_old_app_dir=$www_dir/deploy-old-tatrytec.eu


mkdir -p $tmp_dir
cd $tmp_dir

#git clone https://github.com/camohub/tatrytec.eu.git
echo "---------------------------------------------------"
echo " git clone done "
echo "---------------------------------------------------"

cp $www_dir/tatrytec.eu/.env $tmp_app_dir
mkdir -p $tmp_app_dir/storage/framework/
cp -R $www_dir/tatrytec.eu/storage/framework/sessions/ $tmp_app_dir/storage/framework/
echo "---------------------------------------------------"
echo " .env file + session files copy done "
echo "---------------------------------------------------"

chmod -R 770 $tmp_dir/

cd $tmp_app_dir

# Next commands shall not run as root!!!
#su tatrytec -c 'composer install  --no-scripts'
composer install --optimize-autoloader --no-dev
echo "---------------------------------------------------"
echo " composer install done "
echo "---------------------------------------------------"

npm install
npm run prod
echo "---------------------------------------------------"
echo " npm install + npm run prod done "
echo "---------------------------------------------------"

mv $tmp_app_dir $www_new_app_dir
cd $www_new_app_dir
echo "---------------------------------------------------"
echo " www/deploy-new-tatrytec.eu done "
echo "---------------------------------------------------"

php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "---------------------------------------------------"
echo " artisan config + route + view cache done "
echo "---------------------------------------------------"

# User www-data needs to have rwx permission in storage and cache directories
# TODO: needs to copy storage files to new directory
chmod -R ug+rwx $www_new_app_dir/storage $www_new_app_dir/bootstrap/cache
chgrp -R www-data $www_new_app_dir/storage $www_new_app_dir/bootstrap/cache
echo "---------------------------------------------------"
echo " chmod + chgrp for cache done "
echo "---------------------------------------------------"

# https://stackoverflow.com/questions/30639174/how-to-set-up-file-permissions-for-laravel
# https://vijayasankarn.wordpress.com/2017/02/04/securely-setting-file-permissions-for-laravel-framework/
# https://linuxconfig.org/how-to-explicitly-exclude-directory-from-find-command-s-search
# owner is jenkins group www-data
find $www_new_app_dir -type f -not -path "${www_new_app_dir}/storage/*" -not -path "${www_new_app_dir}/bootstrap/cache/*" -exec chmod 664 {} \;  # chmod for files
find $www_new_app_dir -type d -exec chmod 775 {} \;  # chmod for directories
echo "---------------------------------------------------"
echo " chmod f + chmod d dome "
echo "---------------------------------------------------"

mv $www_dir/tatrytec.publicvm.com $www_old_app_dir
echo "---------------------------------------------------"
echo " old repositories rename done "
echo "---------------------------------------------------"

mv $www_new_app_dir $www_dir/tatrytec.publicvm.com
echo "---------------------------------------------------"
echo " new repository rename done "
echo "---------------------------------------------------"

cd $www_dir/tatrytec.publicvm.com
php artisan storage:link
echo "---------------------------------------------------"
echo " artisan storage:link done "
echo "---------------------------------------------------"

rm -rf $tmp_app_dir
rm -rf $www_old_app_dir
echo "---------------------------------------------------"
echo " new repository rename done "
echo "---------------------------------------------------"

echo "---------------------------------------------------"
echo " CONGRATULATION EVERYTHIG IS DONE "
echo "---------------------------------------------------"










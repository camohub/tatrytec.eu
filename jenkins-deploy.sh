#!/bin/bash

www_dir=/var/www
www_new_app_dir=$www_dir/deploy-new-tatrytec.eu
www_old_app_dir=$www_dir/deploy-old-tatrytec.eu


# git clone is in the pipeline gonfiguration
#git clone https://github.com/camohub/tatrytec.eu.git $www_new_app_dir
cd $www_new_app_dir
echo "---------------------------------------------------"
echo " git clone done "
echo "---------------------------------------------------"

cp $www_dir/tatrytec.eu/.env $www_new_app_dir
mkdir -p $www_new_app_dir/storage/framework/
cp -R $www_dir/tatrytec.eu/storage/framework/sessions/ $www_new_app_dir/storage/framework/
cp -R $www_dir/tatrytec.eu/storage/app/ $www_new_app_dir/storage/
echo "---------------------------------------------------"
echo " .env file + session files + storage/app copy done "
echo "---------------------------------------------------"

chmod -R 770 $www_new_app_dir/

# Next commands shall not run as root!!!
composer install --optimize-autoloader --no-dev
echo "---------------------------------------------------"
echo " composer install done "
echo "---------------------------------------------------"

npm install
npm run prod
echo "---------------------------------------------------"
echo " npm install + npm run prod done "
echo "---------------------------------------------------"

# User www-data needs to have rwx permission in storage and cache directories
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
# https://www.geeksforgeeks.org/access-control-listsacl-linux/
setfacl -dm "g:www-data:rw" $www_new_app_dir/storage
setfacl -dm "g:www-data:rw" $www_new_app_dir/bootstrap
return 0
echo "---------------------------------------------------"
echo " chmod f + chmod d + setfacl dome "
echo "---------------------------------------------------"

mv $www_dir/tatrytec.eu $www_old_app_dir
echo "---------------------------------------------------"
echo " old app folder rename done "
echo "---------------------------------------------------"

mv $www_new_app_dir $www_dir/tatrytec.eu
echo "---------------------------------------------------"
echo " new app folder rename done "
echo "---------------------------------------------------"

cd $www_dir/tatrytec.eu
# After rename to final destination name because cache stores the full paths
php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "---------------------------------------------------"
echo " artisan config + route + view cache done "
echo "---------------------------------------------------"

php artisan storage:link
echo "---------------------------------------------------"
echo " artisan storage:link done "
echo "---------------------------------------------------"

# Does not work with php from console
#cd $www_old_app_dir
#php artisan delete:generated-files

# rm -rf does not work cause Laravel generates files ass www-data user with chmod 644
# which are not possible to delete for jenkins although he belongs to wwwdata group
#rm -rf $www_old_app_dir

echo "---------------------------------------------------"
echo " DEPLOY IS DONE. CHECK ERROR MESSAGES. "
echo "---------------------------------------------------"


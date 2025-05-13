# dreamestate.com.au
Real Estate Listing Platform


        "dev": "vite", // or "npm run dev" if using Laravel Mix
        "build": "vite build", // or "npm run production" if using Laravel Mix
        "watch": "vite build --watch", // or "npm run watch" if using Laravel Mix
        "backend": "php artisan serve" // to start the Laravel backend

# admin login
/admin/login
credentials: superadmin@dreamestate.com/password

# user login
/auth-login
crednetials: testUser@dreamestate.com/password

# agent login
/auth-login
credentials: agent@dreamestate.com/password

# packages installed
composer require yajra/laravel-datatables-oracle

# packages.josn
apexcharts
vue3-apexcharts

# selct field
 use componenets mentioned in backend for select,input,pasword,email..
# use of backkend datatables
checkk usercontroller


# for creating permissions maiintain consistency like
{resourceName}-view
{resourceName}-create
{resourceName}-edit
{resourceName}-delete
 users-view or activityLogs-view


# for datatable actions we have used we have used like this 
view {resourceName}


composer require "maatwebsite/excel:^3.1"

################## DOCKER #########################

#Build and Run Containers
docker-compose build
docker-compose up -d

#Install Laravel Dependencies
docker exec -it laravel_app bash
composer install

#Generate Laravel App Key
php artisan key:generate

#Troubleshooting
[composer not found]
Run this command to see if composer is installed inside the container:
docker exec -it laravel_app bash -c "which composer"
DOWNLOAD IT MANUALLY
1.Enter the container
docker exec -it laravel_app bash
2.
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

#Rebuid the docker to ensure the installed dependencies are available
docker-compose down
docker-compose up -d

################## END DOCKER ######################




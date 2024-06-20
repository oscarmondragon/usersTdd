
User Management App Backend
An Laravel  REST API for user CRUD operations with JWT authentication.

Features
User CRUD operations (Create, Read, Update, Delete).
JWT authentication for secure user login and registration.
Integration with a Laravel backend API.

Technologies Used
Backend (Laravel API)
Laravel (version 10)
JWT authentication)
MySQL ( database)



Installation
To set up the Laravel backend API, follow these steps:

Clone the repository:

git clone https://github.com/oscarmondragon/usersTdd.git
cd usersTdd
Install PHP dependencies:

composer install
Set up your .env file with database:

cp .env.example .env
php artisan key:generate
Configure your database settings in .env:

makefile
Copiar código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=userstdd
DB_USERNAME=root
DB_PASSWORD=
Run migrations to create the necessary tables:

php artisan migrate --seed


Start the Laravel development server:


php artisan serve

Backend (Laravel API)
No additional configuration steps needed for the backend API if .env file is properly configured.

Credits
Vue.js: https://vuejs.org/
Vuetify: https://vuetifyjs.com/
Laravel: https://laravel.com/
MySQL: https://www.mysql.com/

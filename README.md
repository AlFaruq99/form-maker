
# Form Maker

Cara install

- buka terminal
- masuk kedirektori web host local (perintah cd)
- ketik "git clone https://github.com/AlFaruq99/form-maker.git"
- masuk kefolder web form-maker (perintah cd)
- ketik "composer install"
- ketik "npm install"
- buat file .env
- sambungkan dengan datbase postgresql
- ketik "php artisan key:generate"
- ketik "php artisan migrate"
- seeding user
    - admin => "php artisan db:seed AdminSeeder"
    - client => "php artisan db:seed clientSeeder"

Akun
- admin

    username = admin@gmail.com, password = admin123

- client

    username = (lihat email tabel users), password = client123

Menjalankan
php artisan serve


## Badges

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

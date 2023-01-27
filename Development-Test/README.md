### Instalasi

Sebelum melakukan instalasi pastikan sudah terpasang `composer` dan `php`. 

Requitment php min versi 7.4

```php
// Setup library yang dibutuhkan
$ composer install

// Cek .env apakah ter create atau tidak, jika tidak jalankan langkah berikut 
cmd : copy .env.example .env

php artisan key:generate

buat database

setting database file -> .env 

// Setup Database
$ php artisan migrate --seed
```

### Akses Login

| Email                      | Password  |
|----------------------------|-----------|
| admin@test.com        	 | 12345     |

### NOTE Penggunan API
$ Pada File Storage > api-docs > api-docs.json
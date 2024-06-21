# Simdes Skripsi Project

Project ini untuk sistem informasi manajemen desa yang meliputi
- Admin Pane
- User Pane
- Desa Management
- Role/User Management
- Dusun/RW/RT (LKD) Management
- Kependudukan Management
    - Warga
    - Kelompok Rumah Tangga
    - Dinamika Kependudukan
- Layanan Management
    - Permohonan Informasi & Informasi Publik
    - Surat Keterangan
    - Aspirasi
- Statistik Desa
  
## Tentang Sistem

-   PHP 8.2
-   Laravel 10
-   Template bootstrap 5 - [Free Template Sneat](https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/html/)
-   Wilayah Indonesia API - [cahyadsn](https://api.cahyadsn.com/)
-   Yajra Datatable - [yajrabox](https://yajrabox.com/docs/laravel-datatables/10.0/)
-   hash route id - [vinkla/hashids](https://github.com/vinkla/laravel-hashids)

## Cara Penggunaan?

Clone Or Download this repository

```shell
# Clone Repository
$ git clone https://github.com/nym570/simdes.git
```

After clone or download this repository, next step is install all dependency required by laravel and laravel-mix.

```shell
# install composer-dependency
$ composer install
```

Before we start web server make sure we already generate app key, configure `.env` file and do migration.

```shell
# create copy of .env && configuration the database
$ cp .env.example .env
# create laravel key
$ php artisan key:generate
# laravel migrate
$ php artisan migrate:fresh --seed
```

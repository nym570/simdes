<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Pemerintahan;
use App\Models\Desa;
use App\Models\Dusun;
use App\Models\RW;
use App\Models\RT;
use Spatie\Activitylog\Models\Activity;
use App\Models\Warga;
use App\Models\Ruta;
use App\Models\AnggotaRuta;
use App\Models\Dinamika;
use App\Models\Kelahiran;
use App\Models\Kematian;
use App\Models\Kedatangan;
use App\Models\Kepindahan;
use App\Models\Aspirasi;
use App\Models\BalasAspirasi;
use App\Models\InfoPublik;
use App\Models\PengajuanInfoPublik;
use App\Models\SuratKeterangan;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => 'desa',
            'length' => 10,
            // 'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ],
        User::class => [
            'salt' => User::class.'users-desa',
            'length' => 7,
        ],
        Admin::class => [
            'salt' => Admin::class.'users-desa',
            'length' => 7,
        ],
        Desa::class => [
            'salt' => Desa::class.'desa',
            'length' => 7,
        ],
        Pemerintahan::class => [
            'salt' => Pemerintahan::class.'pemerintahan',
            'length' => 4,
        ],
        Dusun::class => [
            'salt' => Dusun::class.'lkd-desa-dusun',
            'length' => 7,
        ],
        RW::class => [
            'salt' => RW::class.'lkd-desa-rw',
            'length' => 7,
        ],
        RT::class => [
            'salt' => RT::class.'lkd-desa-rt',
            'length' => 7,
        ],
        Activity::class => [
            'salt' =>Activity::class.'log',
            'length' => 13,
        ],
        Warga::class => [
            'salt' => Warga::class.'warga-desa',
            'length' => 15,
        ],
        Ruta::class => [
            'salt' => Ruta::class.'ruta-desa',
            'length' => 15,
        ],
        AnggotaRuta::class => [
            'salt' => AnggotaRuta::class.'anggota-ruta-desa',
            'length' => 15,
        ],
        Dinamika::class => [
            'salt' => Dinamika::class.'dinamika-desa',
            'length' => 10,
        ],
        Kelahiran::class => [
            'salt' => Kelahiran::class.'dinamika-kelahiran',
            'length' => 10,
        ],
        Kematian::class => [
            'salt' => Kematian::class.'dinamika-kematian',
            'length' => 10,
        ],
        Kepindahan::class => [
            'salt' => Kepindahan::class.'dinamika-kepindahan',
            'length' => 10,
        ],
        Kedatangan::class => [
            'salt' => Kedatangan::class.'dinamika-kedatangan',
            'length' => 10,
        ],
        Aspirasi::class => [
            'salt' => Aspirasi::class.'aspirasi',
            'length' => 7,
        ],
        BalasAspirasi::class => [
            'salt' => BalasAspirasi::class.'balas-aspirasi',
            'length' => 7,
        ],
        InfoPublik::class => [
            'salt' => InfoPublik::class.'info-publik',
            'length' => 5,
        ],
        PengajuanInfoPublik::class => [
            'salt' => PengajuanInfoPublik::class.'mohon-info',
            'length' => 7,
        ],
        SuratKeterangan::class => [
            'salt' => SuratKeterangan::class.'suket',
            'length' => 10,
        ],

        // 'alternative' => [
        //     'salt' => 'your-salt-string',
        //     'length' => 'your-length-integer',
        //     // 'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        // ],

    ],

];

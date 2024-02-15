<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Desa;
use App\Models\Dusun;
use App\Models\RW;
use App\Models\RT;
use Spatie\Activitylog\Models\Activity;
use App\Models\Warga;

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
            'length' => 10,
        ],
        Warga::class => [
            'salt' => Warga::class.'warga-desa',
            'length' => 10,
        ],

        // 'alternative' => [
        //     'salt' => 'your-salt-string',
        //     'length' => 'your-length-integer',
        //     // 'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        // ],

    ],

];

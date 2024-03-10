<?php
namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class wilayahHelper
{
    public static function getNamaKab($id)
    {
        $response =  Http::get('https://api.cahyadsn.com/regency/'.$id);
        if($response->successful()){
            $data = $response['data']['nama'];
            return Str::title($data);
        }
        return;
    }
    public static function getNamaProv($id)
    {
        $response =  Http::get('https://api.cahyadsn.com/province/'.$id);
        if($response->successful()){
            $data = $response['data']['nama'];
            return Str::title($data);
        }
        return;
    }
    public static function getNamaKec($id)
    {
        $response =  Http::get('https://api.cahyadsn.com/district/'.$id);
        if($response->successful()){
            $data = $response['data']['nama'];
            return Str::title($data);
        }
        return;
    }
    public static function getNamaDes($id)
    {
        $response =  Http::get('https://api.cahyadsn.com/village/'.$id);
        if($response->successful()){
            $data = $response['data']['nama'];
            return Str::title($data);
        }
        return;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Desa;
use Illuminate\Support\Facades\Route;

class BootDesa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $desa = Desa::get()->first();
        if(is_null($desa->kode_wilayah)&&(!(Route::is('admin.*')||Route::is('m.lkd.*')||Route::is('m.desa.*')||Route::is('wilayah.*')||Route::is('master-desa.*')))){
            return  redirect(route('admin.boot'));
        
        }
        else if(Route::is('admin.boot')&&(!is_null($desa->kode_wilayah))){
            return  redirect(route('admin.home'));
        }
        return $next($request);
    }
}

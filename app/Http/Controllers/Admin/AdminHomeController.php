<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;
use App\Models\Dusun;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class AdminHomeController extends Controller
{
    public function index()
	{
		$desa = Desa::get()->first();
		if(is_null($desa->kode_wilayah)){
			return  redirect(route('admin.boot'));
        }
		$title = 'Dashboard Admin';
		$user = User::where('is_active',true);
		$login = Activity::where('description','login')->where('created_at','>=', Carbon::today())->get()->unique('causer_id','causer_type')->count();
		$activity = Activity::where('causer_type', 'App\Models\Admin')->where('causer_id', auth()->guard('admin')->user()->id)->where('created_at','>', Carbon::now()->subMonths(1));
		$client_id = 0;
	
		$data = [
			'user' => $user->count(),
			'last_month_user' => $user->where('created_at','>', Carbon::now()->subMonths(1))->count(),
			'login' => $login,
			'activity' => $activity->count(),
			'activities' => $activity->groupby('event')->selectRaw('count(*) as total, event')->orderBy('total','desc')->pluck('total','event')->all(),
		];
		$dusun = Dusun::all();
		return view('admin.home', compact(['title','data','dusun']));
	}
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class User extends Authenticatable implements MustVerifyEmail
{
	use HasApiTokens, HasFactory, Notifiable, HasRoles, Hashidable,LogsActivity;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = ['id'];
    protected $with = ['warga'];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['username', 'email','status','email_verified_at','password'])
		->logOnlyDirty()
		->dontLogIfAttributesChangedOnly(['remember_token'])
		->useLogName('User');
        // Chain fluent methods for configuration options
    }

	public function tapActivity(Activity $activity, string $event)
{
    /** @var Collection $properties */
    if ($properties = $activity->properties) {
        if ($properties->has('attributes')) {
            $attributes = $properties->get('attributes');
            if (isset($attributes['password'])) {
                $attributes['password'] = '<secret>';
            }
            if(isset($attributes['role'])){
                $attributes['role'] = $attributes['role'];
            }
            if (isset($attributes['email_verified_at'])) {
                if(!is_null($attributes['email_verified_at'])){
                    $attributes['email_verified_at'] = 'email verified';
                }
                else{
                    $attributes['email_verified_at'] = 'email not verified';
                }
                
            }
            $properties->put('attributes', $attributes);
        }
        if ($properties->has('old')) {
            $old = $properties->get('old');
            if (isset($old['password'])) {
                $old['password'] = '<secret>';
            }
            if(isset($old['role'])){
                $old['role'] = $old['role'];
            }
            if (isset($old['email_verified_at'])) {
                if(!is_null($old['email_verified_at'])){
                    $old['email_verified_at'] = 'email verified';
                }
                else{
                    $old['email_verified_at'] = 'email not verified';
                }
            }
            $properties->put('old', $old);
        }
        $activity->properties = $properties;
    }
}
	
	public function warga()
    {
        return $this->belongsTo(Warga::class,'nik', 'nik');
    }
    public function dusun()
    {
        return $this->hasOne(User::class);
    }
    public function rw()
    {
        return $this->hasOne(User::class);
    }
    public function rt()
    {
        return $this->hasOne(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Traits\Hashidable;
use App\Notifications\AdminEmailVerificationNotification;
use App\Notifications\AdminResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Admin extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Hashidable, CanResetPassword,LogsActivity;
    protected $table = 'admin';
    protected $guarded = ['id'];

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
        ->logOnly(['username','nama', 'email','status','password','email_verified_at'])
		->logOnlyDirty()
        ->dontLogIfAttributesChangedOnly(['remember_token'])
		->useLogName('Admin');
        // Chain fluent methods for configuration options
    }

	

	public function sendEmailVerificationNotification()
    {
        // We override the default notification and will use our own
        $this->notify(new AdminEmailVerificationNotification());
    }

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new AdminResetPassword($token));
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
}

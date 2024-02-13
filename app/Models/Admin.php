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

class Admin extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Hashidable, CanResetPassword;
    protected $table = 'users';
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
	public function sendEmailVerificationNotification()
    {
        // We override the default notification and will use our own
        $this->notify(new AdminEmailVerificationNotification());
    }

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new AdminResetPassword($token));
	}
}

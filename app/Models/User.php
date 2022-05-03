<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * Class User
 *
 * @property int $id
 * @property string $fullname
 * @property string $username
 * @property string $password
 * @property string $image
 * @property int $activated
 *
 * @property Collection|Employee[] $employees
 * @property Collection|Schedule[] $schedules
 *
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{

    use Notifiable;

	protected $table = 'users';
	public $timestamps = false;

	protected $casts = [
		'image' => 'boolean',
		'activated' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'fullname',
		'username',
		'password',
		'image',
		'activated'
	];

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}

	public function schedules()
	{
		return $this->hasMany(Schedule::class);
	}




    //JWT

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

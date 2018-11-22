<?php

namespace Gwaps4nlp\Core\Models;

use Gwaps4nlp\Core\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password','role_id'];

    /**
     * The roles that belong to the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsToMany
     */
	public function roles()
	{
		return $this->belongsToMany('Gwaps4nlp\Core\Models\Role');
	}

	/**
	 * Many to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\belongToMany
	 */
	public function bonuses()
	{
		return $this->belongsToMany('Gwaps4nlp\Core\Models\Bonus');
	}

  public function getNextLevelAttribute()
    {
        return $this->level->getNext();
    }

	/**
	 * Many to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\belongToMany
	 */
	public function trophies()
	{
		return $this->belongsToMany('Gwaps4nlp\Core\Models\Trophy');
	}

	/**
	 * Check admin role
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		$role_admin = Role::where('slug','admin')->first();
		return $this->roles->contains('id',$role_admin->id);
	}

	/**
	 *
	 * @return User
	 */
	public static function getAdmins()
	{
		return User::whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('role_user')
                      ->where('role_user.role_id', Role::getAdmin()->id)
                      ->whereRaw('role_user.user_id = users.id');
            })
            ->get();
	}

	/**
	 *
	 * @return User
	 */
	public static function getAdmin()
	{
		return User::where('username','admin')->first();
	}

	/**
	 * Check not user role
	 *
	 * @return bool
	 */
	public function isUser()
	{
		return $this->role->slug == 'user'||$this->role->slug == 'admin';
	}

	/**
	 * Check not user role
	 *
	 * @return bool
	 */
	public function isGuest()
	{
		return $this->role->slug != 'user' && $this->role->slug == 'admin';
	}

	public function hasTrophy($trophy)
	{
		return $this->trophies->contains('id', $trophy->id);
	}

/*
	public function getRememberToken()
	{
		return null; // not supported
	}

	public function setRememberToken($value)
	{
		// not supported
	}

	public function getRememberTokenName()
	{
		return "remember_token"; // not supported
	}
*/
	/**
	* Overrides the method to ignore the remember token.
	*/
/*
	public function setAttribute($key, $value)
	{
		$isRememberTokenAttribute = ($key == $this->getRememberTokenName());
		if (!$isRememberTokenAttribute)
		{
		  parent::setAttribute($key, $value);
		}
	}
	*/
}
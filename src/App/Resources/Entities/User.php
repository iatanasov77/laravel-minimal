<?php namespace App\Resources\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

/**
 * @brief User  entity
 *
 * @author Ivan Atanasov
 */
class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    /**
     * @var     string
     */
    protected $table    = 'um_users';

    /**
     * @var array
     */
    protected $fillable = ['email', 'password', 'name', 'last_name', 'image'];

    /**
     * @brief many to many relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany( 'App\Resources\Entities\Role', 'um_users_roles' );
    }
}

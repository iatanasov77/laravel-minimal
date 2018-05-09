<?php namespace App\Resources\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @brief User's role entity
 *
 * @author Ivan Atanasov
 */
class Role extends Model
{
    const ADMIN         = 1;
    const USER          = 2;
    
    /**
     * @var string
     */
    protected $table    = 'um_roles';
    
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @brief many to many relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany( 'App\Resources\Entities\User', 'um_users_roles' );
    }
}

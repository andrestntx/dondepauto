<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 20/04/2016
 * Time: 4:23 PM
 */

namespace App\Entities\Platform;


class Login extends Entity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_users_logs_LIST';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_log_LI';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha_login_LI'];

    protected $attr  = ['logit_at' => 'fecha_login_LI'];

    public function getLoginAtDatatableAttribute()
    {
        return $this->login_at->format('d/m/Y');
    }

}
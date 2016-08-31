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
    protected $table = 'users_logs_LIST';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_log_LI';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha_login_LI', 'fecha_logout_LI'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_log_LI', 'fecha_login_LI', 'sesion_abandonada_LI'
    ];

    protected $databaseTranslate  = ['login_at' => 'fecha_login_LI', 'logout_at' => 'fecha_logout_LI', 'abandoned' => 'sesion_abandonada_LI'];

    /**
     * @return mixed
     */
    public function getLoginAtDatatableAttribute()
    {
        return $this->login_at->format('d/m/Y');
    }

}
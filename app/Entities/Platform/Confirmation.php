<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 8:55 AM
 */

namespace App\Entities\Platform;

class Confirmation extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_LI';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'us_reg_cod_LIST';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'active', 'code'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $databaseTranslate  = [
        'id' => 'id_LI', 'user_id' => 'id_us_LI', 'active' => 'usuario_act_LI', 'code' => 'cod_act_ha_LI'
    ];

    /**
     * Get the user that owns the confirmation.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_us_LI', 'id_us_LI');
    }

    /**
     * @param $value
     */
    public function setActiveAttribute($value)
    {
        if($value) {
            $this->attributes['usuario_act_LI'] = 'usActsI';
        }
        else {
            $this->attributes['usuario_act_LI'] = 'usActnO';
        }
    }
}
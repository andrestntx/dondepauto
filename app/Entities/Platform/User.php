<?php

namespace App\Entities\Platform;

class User extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_us_LI';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'state', 'space_city_names', 'space_city_ids'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_us_reg_LIST';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role', 'user_id',
        'company', 'company_nit', 'company_role', 'company_area', 'city_id', 'address',
        'phone', 'cel', 'economic_activity_id', 'signed_agreement'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'fecha_registro_Us_LI';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    protected static $roles = ['admin', 'director', 'adviser', 'advertiser' => 'Co_tip_u', 'medium' => 'Ve_tip_u'];

    protected $attr  = [
        'first_name' => 'nombre_us_LI', 'last_name' => 'apellido_us_LI', 'email' => 'email_us_LI', 'role' => 'tipo_us_LI',
        'company' => 'empresa_us_LI', 'id' => 'id_us_LI', 'company_nit' => 'nit_empresa_us_LI', 'company_role' => 'cargo_us_LI',
        'company_area' => 'area_cargo_us_LI', 'city_id' => 'id_ciudad_LI', 'address' => 'direccion_us_LI', 'phone' => 'telefono_fijo_us_LI',
        'cel' => 'celular_us_LI', 'password' => 'clave_us_LI', 'economic_activity_id' => 'id_actividadEconomica_LI',
        'signed_agreement' => 'firmo_acuerdo_LI', 'signed_at' => 'fecha_firma_acuerdo_us_LI', 'commission_rate' => 'porc_comision_us_LI',
        'retention' => 'retencion_fuente_us_LI', 'discount' => 'descuento_pronto_pago_us_LI', 'created_at' => 'fecha_registro_Us_LI'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function confirmation()
    {
        return $this->hasOne(Confirmation::class, 'id_us_LI', 'id_us_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'id_ciudad_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo(EconomicActivity::class, 'id_actividadEconomica_LI');
    }
    
    /**
     * @param $role
     * @return mixed
     */
    public static function getRole($role)
    {
        return self::$roles[$role];
    }

    /**
     * @return string
     */
    public function getActivityNameAttribute()
    {
        if($this->activity){
            return $this->activity->name;
        }

        return 'Sin actividad';
    }

    /**
     * @return string
     */
    public function getCityNameAttribute()
    {
        if($this->city){
            return $this->city->name;
        }

        return 'Sin ciudad';
    }

    /**
     * @return mixed
     */
    public function getCreatedAtMixpanelAttribute()
    {
        return $this->created_at->toDateTimeString();
    }

    /**
     * Encrypt the users password
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['clave_us_LI'] = \Hash::make($value);
        }
    }

    public function setSignedAgreementAttribute($value)
    {
        if($value) {
            $this->attributes['firmo_acuerdo_LI'] = 'Si_fir_ac';
        }
        else {
            $this->attributes['firmo_acuerdo_LI'] = 'No_fir_ac';
        }
    }

    /**
     * @return bool
     */
    public function getSignedAgreementAttribute()
    {
        return $this->firmo_acuerdo_LI == 'Si_fir_ac';
    }

    /**
     * @return string
     */
    public function getSignedAgreementLangAttribute()
    {
        if($this->signed_agreement)
        {
            return 'Si';
        }

        return 'No';
    }

    /**
     * Search the role in the roles array
     * @param $value
     */
    public function setRoleAttribute($value)
    {
        if (!empty($value) && array_key_exists($value, self::$roles)) {
            $this->attributes['tipo_us_LI'] = self::getRole($value);
        }
        else if(!empty($value)) {
            $this->attributes['tipo_us_LI'] = $value;
        }
    }

    /**
     * @param $query
     * @param $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole($query, $role)
    {
        if(array_key_exists($role, self::$roles)){
            $role = self::$roles[$role];
        }

        return $query->where('tipo_us_LI', '=', $role);
    }

    /**
     * @param $query
     * @param array $roles
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRoles($query, array $roles)
    {
        return $query->whereIn('tipo_us_LI', $roles);
    }

    /**
     * @param $query
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->whereUserId($userId);
    }

    /**
     * @param $query
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInIds($query, array $ids)
    {
        return $query->whereIn('id_us_LI', $ids);
    }

    /**
     * @return mixed
     */
    public function getRoleAttribute()
    {
        return array_search($this->tipo_us_LI, self::$roles);
    }

    /**
     * Return the Full Name
     * @return string
     */
    public function getNameAttribute()
    {
        return ucwords(strtolower($this->first_name . ' ' . $this->last_name));
    }

    /**
     * @return string
     */
    public function getStateAttribute()
    {
        return 'Activo';
    }

    /**
     * @return string hash
     */
    public function getMailchimpIdAttribute()
    {
        return md5(strtolower($this->email));
    }

    public function spaces()
    {
        return $this->hasMany('App\Entities\Platform\Space', 'id_us_reg_LI', 'id');
    }

    public function getSpaceCityNamesAttribute()
    {
        return $this->spaces->lists('city_name');
    }

    public function getSpaceCityIdsAttribute()
    {
        return $this->spaces->lists('id_ciudad_LI');
    }
}

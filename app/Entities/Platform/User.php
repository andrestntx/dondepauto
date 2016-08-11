<?php

namespace App\Entities\Platform;

use App\Entities\Views\Advertiser;
use App\Entities\Views\Publisher;
use App\Repositories\File\PublisherDocumentsRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

class User extends EntityAuth
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
    protected $appends = ['states', 'source' /*'name', 'space_city_names', 'space_city_ids', 'states'*/];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'us_reg_LIST';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role', 'user_id', 'name',
        'company', 'company_nit', 'company_role', 'company_area', 'city_id', 'address',
        'phone', 'cel', 'economic_activity_id', 'signed_agreement', 'comments', 'signed_at',
        'commission_rate', 'retention', 'discount', 'complete_data', 'company_legal'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha_activacion_Us_LI', 'fecha_registro_completo_Us_LI'];

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

    protected static $roles = ['admin', 'director', 'adviser', 'advertiser' => 'Co_tip_u', 'publisher' => 'Ve_tip_u'];

    protected $databaseTranslate  = [
        'first_name' => 'nombre_us_LI', 'last_name' => 'apellido_us_LI', 'email' => 'email_us_LI', 'role' => 'tipo_us_LI',
        'company' => 'empresa_us_LI', 'id' => 'id_us_LI', 'company_nit' => 'nit_empresa_us_LI', 'company_role' => 'cargo_us_LI',
        'company_area' => 'area_cargo_us_LI', 'city_id' => 'id_ciudad_LI', 'address' => 'direccion_us_LI', 'phone' => 'telefono_fijo_us_LI',
        'cel' => 'celular_us_LI', 'password' => 'clave_us_LI', 'economic_activity_id' => 'id_actividadEconomica_LI',
        'signed_agreement' => 'firmo_acuerdo_LI', 'signed_at' => 'fecha_firma_acuerdo_us_LI', 'commission_rate' => 'porc_comision_us_LI',
        'retention' => 'retencion_fuente_us_LI', 'discount' => 'descuento_pronto_pago_us_LI', 'created_at' => 'fecha_registro_Us_LI',
        'comments' => 'comentarios_us_LI', 'complete_data' => 'es_us_activo_LI', 'company_legal' => 'razon_social_us_LI',
        'private' => 'opcion_espacios_privados_LI', 'activated_at' => 'fecha_activacion_Us_LI', 'completed_at' => 'fecha_registro_completo_Us_LI',
        'source' => 'bd_form_fuente_LI'
    ];

    /**
     * Get the value of an attribute using its mutator for array conversion.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function mutateAttributeForArray($key, $value)
    {
        if($this->isInTranslate($key) && ! $this->hasGetMutator($key)) {
            $value = parent::getAttribute($this->getTranslateKey($key));
        }
        else if(! $this->hasGetMutator($key) && $this->exists && $this->type()->getAttribute($key)) {
            $value = $this->type()->getAttribute($key);
        }
        else {
            $value = $this->mutateAttribute($key, $value);
        }

        return $value instanceof Arrayable ? $value->toArray() : $value;
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if(is_null($value) && $this->exists){
            $value = $this->type()->getAttribute($key);
        }

        return $value;
    }

    /**
     * @return float
     */
    public function getAvgPointsAttribute()
    {
        return round($this->spaces->avg('new_points'), 0);
    }


    /**
     * @return bool
     */
    public function getHasOffersAttribute()
    {
        if($this->spaces->count() > 0){
            return true;
        }

        return false;
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function publisher()
    {
        return $this->hasOne(Publisher::class, 'id', 'id_us_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function representative()
    {
        return $this->hasOne(Representative::class, 'publisher_id', 'id_us_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function advertiser()
    {
        return $this->hasOne(Advertiser::class, 'id', 'id_us_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Entities\User', 'user_platform_id', 'id_us_LI');
    }

    /**
     * @return mixed
     */
    public function getCountSpacesAttribute()
    {
        return $this->spaces->count();
    }

    /**
     * @return Representative|mixed
     */
    public function getRepresentativeOrNew()
    {
        if($repre = $this->representative) {
            return $repre;
        }

        return new Representative();
    }

    /**
     * @return Model
     */
    public function type()
    {
        if($this->isRole('publisher')) {
            return $this->publisher;
        }
        
        return $this->advertiser;
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

    public function getRepresentativeNameAttribute()
    {
        if($repre = $this->representative) {
            return $repre->name;
        }

        return '';
    }

    public function getRepresentativeFirstNameAttribute()
    {
        if($repre = $this->representative) {
            return $repre->first_name;
        }

        return '';
    }

    public function getRepresentativeDocAttribute()
    {
        if($repre = $this->representative) {
            return $repre->doc;
        }

        return '';
    }

    public function getRepresentativePhoneAttribute()
    {
        if($repre = $this->representative) {
            return $repre->phone;
        }

        return '';
    }

    public function getRepresentativeEmailAttribute()
    {
        if($repre = $this->representative) {
            return $repre->email;
        }

        return '';
    }


    /**
     * @return mixed
     */
    public function getBank()
    {
        if($this->banks) {
            return $this->banks->first();
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getBankAccountNumberAttribute()
    {
        if($bank = $this->getBank()) {
            return $bank->pivot->account_number;
        }

        return '-';
    }

    /**
     * @return mixed
     */
    public function getBankNameAttribute()
    {
        if($bank = $this->getBank()) {
            return $bank->name;
        }

        return '-';
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
    public function getHasSignedAgreementAttribute()
    {
        if($this->signed_agreement == 'Si_fir_ac') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getHasDocumentsAttribute()
    {
        $fileRepository = new PublisherDocumentsRepository();
        return $fileRepository->hasFiles($this);
    }

    /**
     * @return bool
     */
    public function getInVerificationAttribute()
    {
        if(! $this->has_signed_agreement && $this->has_documents) {
            return true;
        }

        return false;
    }

    /**
     * @param $name
     * @return string
     */
    public function getDocument($name)
    {
        $fileRepository = new PublisherDocumentsRepository();

        return $fileRepository->getDocument($this, $name);
    }


    /**
     * @return array
     */
    public function getDocuments()
    {
        $fileRepository = new PublisherDocumentsRepository();
        return $fileRepository->getDocuments($this);
    }

    /**
     * @return string
     */
    public function getDocumentsJsonAttribute()
    {
        return json_encode($this->getDocuments());
    }

    /**
     * @return bool
     */
    public function getExpiredOffersAttribute()
    {
        if(! $this->has_signed_agreement && $this->expired_offers_days <= 0) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getExpiredOffersDaysAttribute()
    {
        return 30 - $this->created_at->diff(Carbon::now())->days;
    }

    /**
     * @param $value
     */
    public function setCompleteDataAttribute($value)
    {
        if($value) {
            $this->attributes['es_us_activo_LI'] = 'act_Sta';
        }
        else {
            $this->attributes['es_us_activo_LI'] = 'desact_Sta';
        }
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $names = explode(' ', $value);
        $this->first_name = $names[0];
        $this->last_name  = implode(' ', array_slice($names, 0));
    }

    /**
     * @return mixed
     */
    public function getEmailValidatedAttribute()
    {
        return $this->confirmation->active;
    }

    /**
     * @return bool
     */
    public function getCompleteDataAttribute()
    {
        if($this->es_us_activo_LI == 'act_Sta') {
            return true;
        }

        return false;
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
     * @param $query
     * @param bool $complete
     * @return mixed
     */
    public function scopeComplete($query, $complete = true)
    {
        if($complete) {
            $complete = 'act_Sta';
        }
        else {
            $complete = 'desact_Sta';
        }

        return $query->where('es_us_activo_LI', '=', $complete);
    }

    public function scopeHasSigned($query, $hasSigned = true)
    {
        if ($hasSigned) {
            $hasSigned = 'act_Sta';
        } else {
            $hasSigned = 'desact_Sta';
        }

        return $query->where('firmo_acuerdo_LI', '=', $hasSigned);
    }


    /**
     * @return mixed
     */
    public function getRoleAttribute()
    {
        return array_search($this->tipo_us_LI, self::$roles);
    }

    /**
     * @param string $role
     * @return bool
     */
    public function isRole($role)
    {
        return $role == $this->role;
    }

    /**
     * @return bool
     */
    public function isPublisher()
    {
        return $this->isRole('publisher');
    }

    /**
     * @return string hash
     */
    public function getMailchimpIdAttribute()
    {
        return md5(strtolower($this->email));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces()
    {
        return $this->hasMany('App\Entities\Platform\Space\Space', 'id_us_reg_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Entities\Platform\Contact', 'user_id', 'id_us_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function banks()
    {
        return $this->belongsToMany('App\Entities\Platform\Bank', 'bank_user', 'publisher_id', 'bank_id')
            ->withPivot('account_number');
    }


    /**
     * @return mixed
     */
    public function getSpaceCityNamesAttribute()
    {
        return $this->spaces->lists('city_name');
    }

    /**
     * @return mixed
     */
    public function getSpaceCityIdsAttribute()
    {
        return $this->spaces->lists('id_ciudad_LI');
    }

    /**
     * @return mixed
     */
    public function getLastOfferAttribute()
    {
        return $this->spaces->max('created_at');
    }

    /**
     * @return mixed
     */
    public function getLastOfferCreatedAtAttribute()
    {
        if($space = $this->last_offer) {
            return $space->created_at;
        }

        return null;
    }
}

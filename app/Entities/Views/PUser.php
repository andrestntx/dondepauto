<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:33 PM
 */

namespace App\Entities\Views;


use Illuminate\Database\Eloquent\Model;

class PUser  extends Model {
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'activated_at'];

    protected $classes = [
        'complete-data'   => 'primary',
        'incomplete' => 'warning',
        'email-no-validated' => 'danger'
    ];

    protected $icons = [
        'complete-data'   => 'fa fa-check',
        'incomplete' => 'fa fa-warning',
        'email-no-validated' => 'fa fa-envelope'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Entities\Platform\Login', 'id_user_log_LI', 'id');
    }

    /**
     * @param $value
     * @return string
     */
    public function getClass($value) {
        if($value) {
            return 'primary';
        }

        return 'danger';
    }

    /**
     * @return array
     */
    public function getStatesAttribute()
    {
        return [
            'initial' => [
                'icon'  => 'fa fa-child',
                'class' => $this->getClass(true),
                'text'  => 'Registro inicial'
            ],
            'email' => [
                'icon'  => 'fa fa-envelope',
                'class' => $this->getClass($this->email_validated),
                'text'  => 'Validación de email'
            ],
            'complete' => [
                'icon'  => 'fa fa-edit',
                'class' => $this->getClass($this->email_validated && $this->complete_data),
                'text'  => 'Complementario'
            ]
        ];
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
     * Return the company name uppercase
     * @param $value
     * @return string
     */
    public function getCompanyAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    /**
     * @return mixed
     */
    public function getLastLog()
    {
        return $this->logs->max('fecha_login_LI');
    }

    /**
     * @return string
     */
    public function getLastLogLoginAtDatatableAttribute()
    {
        if($lasLog = $this->getLastLog())
        {
            return $lasLog->format('d/m/Y');
        }
    
        return '';
    }

    /**
     * @return mixed
     */
    public function getCreatedAtDatatableAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * @return mixed
     */
    public function getActivatedAtDatatableAttribute()
    {
        return $this->activated_at->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getStateIdAttribute()
    {
        if($this->email_validated && $this->complete_data){
            return 'complete-data';
        }
        else if($this->email_validated){
            return 'incomplete';
        }
    
        return 'email-no-validated';
    }

    /**
     * @return string
     */
    public function getStateAttribute()
    {
        return \Lang::get('states.registration.' . $this->state_id);
    }

    /**
     * @return string
     */
    public function getStateClassAttribute()
    {
        return $this->classes[$this->state_id];
    }

    /**
     * @return string
     */
    public function getStateIconAttribute()
    {
        return $this->icons[$this->state_id];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:33 PM
 */

namespace App\Entities\Views;


use App\Entities\Platform\Tag;
use App\Repositories\File\LogosRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PUser  extends Model {

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'activated_at', 'deleted_at', 'completed_at'];

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

    protected $lasLog = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Entities\Platform\Login', 'id_user_log_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    /**
     * @param $value
     * @param bool $other
     * @return string
     */
    public function getClass($value, $other = false) {
        if($value) {
            return 'primary';
        }
        else if($other) {
            return 'info';
        }

        return 'danger';
    }

    /**
     * @return string
     */
    public function getActivatedAtHumansAttribute()
    {
        if($this->activated_at && $this->activated_at->format('d-M-y') != "30-Nov--1") {
            return $this->activated_at->format('d-M-y') . ' - ' . ucfirst($this->activated_at->diffForHumans());
        }

        return '';
    }

    /**
     * @return string
     */
    public function getCompletedAtHumansAttribute()
    {
        if($this->completed_at && $this->completed_at->format('d-M-y') != "30-Nov--1") {
            return $this->completed_at->format('d-M-y') . ' - ' . ucfirst($this->completed_at->diffForHumans());
        }

        return '';
    }

    /**
     * @return array
     */
    public function getStatesAttribute()
    {
        return [
            'email' => [
                'icon'  => 'fa fa-envelope',
                'class' => $this->getClass($this->email_validated),
                'text'  => 'Validación de email',
                'date'  => $this->activated_at_humans
            ],
            'complete' => [
                'icon'  => 'fa fa-edit',
                'class' => $this->getClass($this->email_validated && $this->complete_data),
                'text'  => 'Complementario',
                'date'  => $this->completed_at_humans
            ]
        ];
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
    public function getCountLogsAttribute()
    {
        return $this->logs->count();
    }

    /**
     * @return mixed
     */
    public function getLastContact()
    {
        return $this->contacts->sortBy(function ($contact, $key) {
            return $contact->created_at;
        })->last();
    }

    /**
     * @return null
     */
    public function getLastAction()
    {
        if($lastContact = $this->getLastContact()) {
            return $lastContact->actions->first();
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getLastLog()
    {
        if(is_null($this->lasLog)) {
            $this->lasLog = $this->logs->max('fecha_login_LI');
        }

        return $this->lasLog;
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
     * @return string
     */
    public function getLastLoginAtHumansAttribute()
    {
        if($lasLog = $this->getLastLog())
        {
            return $lasLog->format('d-M-y');
        }

        return '';
    }


    /**
     * @return string
     */
    public function getLastLoginAtAttribute()
    {
        if($lasLog = $this->getLastLog())
        {
            return $lasLog->format('d-M-y') . ' / ' . ucfirst($lasLog->diffForHumans());
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getCreatedAtDatatableAttribute()
    {
        return $this->created_at->format('Y-m-d');
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
     * @param $state
     * @return bool
     */
    public function hasState($state)
    {
        if(trim($state)) {
            if($state == 'agreement' && $this->signed_agreement) {
                return true;
            }
            else if($state == 'docs' && $this->has_documents) {
                return true;
            }
            else if($state == 'letter' && ($this->has_letter || $this->has_documents)) {
                return true;
            }
            else if($state == 'offers' && $this->has_offers) {
                return true;
            }
            else if($state == 'has-views' && $this->count_views > 0) {
                return true;
            }
            else if($state == 'has-favorites' && $this->count_favorites > 0) {
                return true;
            }
            else if($state == 'complete-data' && $this->email_validated && $this->complete_data) {
                return true;
            }
            else if($state == 'incomplete' && ! $this->complete_data && $this->email_validated) {
                return true;
            }
            else if($state == 'email-no-validated' && ! $this->email_validated) {
                return true;
            }

            return false;
        }

        return true;
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

    /**
     * @return bool
     */
    public function getHasLogoAttribute()
    {
        $logoRepository = new LogosRepository();
        return $logoRepository->hasLogoId($this->id);
    }

    /**
     * @return string
     */
    public function getLogoAttribute()
    {
        $logoRepository = new LogosRepository();
        return $logoRepository->getLogoId($this->id);
    }

    /**
     * @return string
     */
    public function getFullLogoAttribute()
    {
        return url($this->logo);
    }

}
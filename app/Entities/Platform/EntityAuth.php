<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 7/26/16
 * Time: 12:02 PM
 */

namespace App\Entities\Platform;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class EntityAuth extends Authenticatable
{
    /**
     * Database translate - Fix Database bad design
     *
     * @var array
     */
    protected $databaseTranslate = array();

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Validate if the key exists in the $databaseTranslate
     *
     * @param $key
     * @return mixed
     */
    protected function isInTranslate($key)
    {
        return array_key_exists($key, $this->databaseTranslate);
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function getTranslateKey($key)
    {
        if($this->isInTranslate($key)) {
            return $this->databaseTranslate[$key];
        }

        return null;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getTranslateOrOriginalKey($key)
    {
        if($translateKey = $this->getTranslateKey($key)) {
            return $translateKey;
        }

        return $key;
    }

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
        if (array_key_exists($key, $this->attributes) || $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }

        return parent::getAttribute($this->getTranslateOrOriginalKey($key));
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set'.Str::studly($key).'Attribute';

            return $this->{$method}($value);
        }

        // If an attribute is listed as a "date", we'll convert it from a DateTime
        // instance into a form proper for storage on the database tables using
        // the connection grammar's date format. We will auto set the values.
        elseif ($value && (in_array($key, $this->getDates()) || $this->isDateCastable($key))) {
            $value = $this->fromDateTime($value);
        }

        // If an attribute is listed as a "special attribute" that must be translated,
        // we'll get the original attribute of the database
        elseif($this->isInTranslate($key)) {
            $key = $this->getTranslateKey($key);
        }

        if ($this->isJsonCastable($key) && ! is_null($value)) {
            $value = $this->asJson($value);
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getFormValue($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * @return mixed
     */
    public function getIdAttribute()
    {
        if(array_key_exists($this->getKeyName(), $this->attributes)){
            return $this->attributes[$this->getKeyName()];
        }

        return $this->attributes['id'];
    }
}
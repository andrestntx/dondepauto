<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 13/04/2016
 * Time: 5:32 PM
 */

namespace App\Entities\Platform;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Entity extends Model
{
    protected $attr = array();

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $key
     * @return mixed
     */
    public function getFormValue($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getAttrKey($key)
    {
        if(array_key_exists($key, $this->attr)) {
            return $this->attr[$key];
        }

        return $key;
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

        return parent::getAttribute($this->getAttrKey($key));
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
        elseif(array_key_exists($key, $this->attr)) {
            $key = $this->attr[$key];
        }
        
        if ($this->isJsonCastable($key) && ! is_null($value)) {
            $value = $this->asJson($value);
        }

        $this->attributes[$key] = $value;

        return $this;
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
<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Model
 */
class Configuration extends \Eloquent
{

    protected $guarded    = array();
    protected $primaryKey = 'key';
    protected $table      = 'configuration';

    /**
     * Retrieves the value for a particular configuration setting.
     *
     * @param  string  $key
     * @return string
     */
    public static function get($key, $default = '')
    {
        $config = parent::find($key);

        return (! $config) ? $default : $config->value;
    }

    /**
     * Stores the $value for configuration $key.
     *
     * @param  string  $key
     * @param  string  $value
     * @return boolean
     */
    public static function set($key, $value)
    {
        $config = parent::find($key);

        if (! $config) {
            return parent::create(array(
                'key'   => $key,
                'value' => $value,
            ));
        } else {
            $config->value = $value;

            return $config->save();
        }
    }

}

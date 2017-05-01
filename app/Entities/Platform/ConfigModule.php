<?php
namespace App\Entities\Platform;

class ConfigModule extends Entity
{
    protected $primaryKey = 'id';

    protected $table = 'config_modules';

    protected $appends = ['name', 'start'];

    public static function getConfig($name)
    {
        return self::whereName($name)->firstOrFail();
    }

    public static function getStartConfig($name)
    {
        return (boolean) self::getConfig($name)->start;
    }

    public static function setStartConfig($name, $start)
    {
        $config = self::getConfig($name);
        $config->start = $start;
        $config->save();

        return $config;
    }
}
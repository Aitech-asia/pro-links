<?php

namespace ProCore\Pattern;

abstract class Singleton
{

    /**
     * Instances
     *
     * @var array
     */
    private static $instances = array();

    protected function __construct(array $settings = array())
    {
    }

    /**
     * Get singleton instance
     *
     * @param array $settings
     *
     * @return static
     */
    public static function get_instance(array $settings = array())
    {
        $class_name = get_called_class();
        if (!isset(self::$instances[$class_name])) {
            self::$instances[$class_name] = new $class_name($settings);
        }
        return self::$instances[$class_name];
    }
}
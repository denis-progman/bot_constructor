<?php


namespace BotConstructor\core;


class ModelFather
{
    protected static ?array $config = null;

    public static function builder()
    {
        self::$config = (include 'app_config.php')[strtolower(static::getClassName())];

    }

    protected static function getClassName(): string
    {
        $class = explode('\\', static::class);
        return $class[count($class)-1];
    }
}
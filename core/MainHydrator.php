<?php

namespace BotConstructor\core;

use BotConstructor\core\easy\EasyHelper;

class MainHydrator
{
    const NAMESPACE_CLASSES = "";

    const FULL_NAMES_CLASSES = [];

    const PARAMS_MAPPER = [];

    public static function hydrate(array $params, object $model): object {
        foreach ($params as $paramKey => $paramValue){
            $className = EasyHelper::toCamelCase($paramKey, true);

            if (isset(static::PARAMS_MAPPER[$className])) { // field mapping
                $className = static::PARAMS_MAPPER[$className];
            }

            if (
                self::checkModelClassExist($className)
                && is_array($paramValue)
                && !is_numeric($paramKey)
            ) {
                $paramObject = static::reHydrate($paramValue, $className);
                self::writeProperty($model, $className, $paramObject);
            }
            elseif (
                self::checkModelClassExist($className)
                && is_array($paramValue)
            ) {
                $arrayObjects = null;
                foreach ($paramValue as $oneValParam) {
                    $paramObject = static::reHydrate($oneValParam, $className);
                    $arrayObjects[] = $paramObject;
                }
                self::writeProperty($model, $className, $arrayObjects);
            }
            else {
                self::writeProperty($model, $className, $paramValue);
            }
        }
        return $model;
    }

    /**
     * @throws \Exception
     */
    protected static function reHydrate(array $param, string $className): object
    {
        $fieldClass = null;
        if (!$fullClassName = static::checkModelClassExist($className)){
            throw new \Exception("Error: While reHydrate not found class for '$fieldClass'");
        }
        return self::hydrate($param, new $fullClassName);
    }

    protected static function writeProperty(object &$model, string $property, $propertyValue): void
    {
        if (property_exists($model, lcfirst($property))) {
            $model->{'set' . ucfirst($property)}($propertyValue);
        }
    }

    public static function checkModelClassExist(string $className): ?string
    {
        if (static::NAMESPACE_CLASSES && class_exists(static::NAMESPACE_CLASSES . $className)){
            return static::NAMESPACE_CLASSES . $className;
        }
        foreach (static::FULL_NAMES_CLASSES as $oneFulNameClass) {
            if (substr(strrchr($oneFulNameClass, "\\"), 1) == $className) {
                return $oneFulNameClass;
            }
        }
        return null;
    }

}
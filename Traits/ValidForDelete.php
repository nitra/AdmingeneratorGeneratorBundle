<?php

namespace Admingenerator\GeneratorBundle\Traits;

trait ValidForDelete
{
    /**
     * Проверяет, можно ли удалять объект
     * @return boolean
     */
    public function isValidForDelete()
    {
        // проверка наличия связей с другими объектами
        $reflectionClass = new \ReflectionClass($this);

        $return = true;

        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($this);
            if ($value instanceof \Doctrine\ORM\PersistentCollection) {
                if ($value->count() > 0) {
                    $return = false;
                }
            }
        }

        return $return;
    }
}

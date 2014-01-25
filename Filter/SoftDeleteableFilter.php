<?php

namespace Admingenerator\GeneratorBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData,
    Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * The SoftDeleteableFilter adds the condition necessary to
 * filter entities which were deleted "softly"
 */
class SoftDeleteableFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        $traitNames = $targetEntity->reflClass->getTraitNames();

        if (!in_array('Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable', $traitNames)) {
            return '';
        }

        return $targetTableAlias . '.deleted_at IS NULL';
    }
}

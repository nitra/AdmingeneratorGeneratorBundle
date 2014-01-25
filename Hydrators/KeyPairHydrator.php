<?php

namespace Admingenerator\GeneratorBundle\Hydrators;

use Doctrine\ORM\Internal\Hydration\AbstractHydrator;

/**
 * Ключ значение
 */
class KeyPairHydrator extends AbstractHydrator
{
    protected function hydrateAllData()
    {
        return $this->_stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
}

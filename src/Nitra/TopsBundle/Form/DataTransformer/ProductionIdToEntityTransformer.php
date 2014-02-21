<?php
namespace Nitra\TopsBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * WarehouseIdToEntityTransformer
 */
class ProductionIdToEntityTransformer implements DataTransformerInterface
{
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     * Constructor
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        
//        var_dump(get_class($em));
////        die('ss');
        

        $this->em = $em;
    }

    /**
     * Transforms an object to a string.
     * @param  object|null $transformObj
     * @return string
     */
    public function transform($transformObj)
    {

        if (null === $transformObj) {
            return "";
        }

        
        return $transformObj->getId();
    }

    /**
     * Transforms a string (id) to an object.
     * @param  string $id
     * @return $transformObj|null
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($id)
    {

        if (!$id) {
            return null;
        }
        $transformObj = $this->em
            ->getRepository('NitraTopsBundle:Production')
            ->findOneBy(array('id' => $id)) ;

        if (null === $transformObj) {
            throw new TransformationFailedException(sprintf('An object with Id "%s" does not exist!', $id));
        }

        return $transformObj;
    }
}

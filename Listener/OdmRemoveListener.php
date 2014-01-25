<?php

namespace Admingenerator\GeneratorBundle\Listener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

/**
 * Odm remove listener.
 * Запрет на удаление связаных документов.
 */
class OdmRemoveListener
{
  
    public function preRemove(LifecycleEventArgs $args)
    {
        $dm = $args->getDocumentManager();
        $currentDocument = $args->getDocument();
        $currentDocumentClass = get_class($currentDocument);
        $isRefExists = FALSE;

        $documentClassNames = $dm->getConfiguration()
                                          ->getMetadataDriverImpl()
                                          ->getAllClassNames();
                                  
        foreach ($documentClassNames AS $documentClassName) {
            try {
                $cm = $dm->getClassMetadata($documentClassName);

                foreach ($cm->getAssociationNames() as $associationName) {
                    if(($currentDocumentClass == $cm->getAssociationTargetClass($associationName)) || is_subclass_of($currentDocumentClass, $cm->getAssociationTargetClass($associationName))) {    
                        $searchObj = $dm->getRepository($documentClassName)->findOneBy(array($associationName . '.$id' => new \MongoId($currentDocument->getId())));
                        if($searchObj){
                            $isRefExists = TRUE;
                        }
                    }
                }
            } catch(\Exception $e) {
            }
        }
        if($isRefExists){
            throw new \Exception('ref_erro');
        }
    }

}


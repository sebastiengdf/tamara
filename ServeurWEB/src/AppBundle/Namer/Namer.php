<?php
namespace AppBundle\Namer;

use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
* Namer class.
  */
  class Namer implements NamerInterface
  {
  private $container;
  
  public function __construct($container)
  {
      $this->container = $container;
  }
  
  /**
  * Creates a name for the file being uploaded.
    *
  * @param object $obj The object the upload is attached to.
  * @return string The file name.
    */
    function name($obj, PropertyMapping $mapping)
    {
    $mapping = $this->getMapping($obj, $fieldName);
    dump($mapping);die;
    
    $file = $mapping->getFile($obj);
    $newName = uniqid();
    
    if ($extension = $file->guessExtension()) {
        $newName = sprintf('%s.%s', $newName, $extension);
    }
    
    return $this->concatenateFullPath($newName);
    }
  
  private function concatenateFullPath($newName)
  {
      return $this->container->get('request')->getSchemeAndHttpHost() .
          $this->container->getParameter('upload_files_path') .
          $newName;
  }
 }
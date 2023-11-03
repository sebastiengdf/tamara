<?php

namespace WorkflowBundle\Exception;

use \Exception;

/**
* Définition de BadStepException
*/
class BadStepException extends Exception
{
  // Ajout d'un préfixe au nom de l'exception
  public function __construct($message, $code = 0, Exception $previous = null) {

    $message_prefix = "BadStepException → ";

    $message = $message_prefix.$message;

    // Lancement de l'exception via la fonction de la classe mère
    parent::__construct($message, $code, $previous);
  }
}

<?php

// src/IntegrationBundle/Antispam/Antispam.php


namespace Blog\IntegrationBundle\Antispam;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

//private $logger;

class Antispam extends Controller

{

  /**

   * Vérifie si le texte est un spam ou non

   *

   * @param string $text

   * @return bool

   */

  public function isSpam($text)

  {

    return strlen($text) < 50;

  }
  
  /**

   * Vérifie si le texte est un integer ou non

   *

   * @param string $text

   * @return bool

   */

  public function isInteger($logger, $text, $antispamFormat)
  {
    
     
    $isValid = true;  
    if (!preg_match($antispamFormat, $text)) {
        // Error
        $isValid = false;
    } else {
        // Continue
        $isValid = true;
    }
      
    return $isValid;
 

  }

}
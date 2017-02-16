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

class Antispam extends \Twig_Extension

{

    private $logger;
 

  public function __construct($logger)

  {

    $this->logger    = $logger;

    

  }
  
  /**

   * Vérifie si le texte est un spam ou non

   *

   * @param string $text

   * @return bool

   */

  public function isSpam($text)

  {

    if(strlen($text) < 50){
        
    }
    return new Response('é < 50');
    //return strlen($text) < 50;

  }
  
  /**

   * Vérifie si le texte est un integer ou non

   *

   * @param string $text

   * @return bool

   */

  public function isInteger($text, $antispamFormat)
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
  
  // Twig va exécuter cette méthode pour savoir quelle(s) fonction(s) ajoute notre service
  public function getFunctions()
  {
    return array(
      'checkIfSpam' => new \Twig_Function_Method($this, 'isSpam')
    );
  }

  // La méthode getName() identifie votre extension Twig, elle est obligatoire
  public function getName()
  {
    return 'Antispam';
  }
  

}
<?php

// src/IntegrationBundle/Antispam/Antispam.php


namespace Blog\CsvParserBundle\Parser\Csv;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

use Blog\IntegrationBundle\Entity\Contenu;

//private $logger;

class CsvParser extends Controller

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

  public function saveRow2($logger, $currentRows, $formatFichier = NULL)
  {
      $logger->info(__METHOD__);
      $logger->info('ser : ' . serialize($currentRows));
    
     
    foreach($currentRows as $currentRow){
        //$em = $this->getDoctrine()->getManager();

        $logger->debug('Ajout du titre  ' . $currentRow . ' en base');

        // On crée une nouvelle annonce
//        $contenu = new \Blog\IntegrationBundle\Entity\Contenu;
//        $contenu->setTitre($currentRow);
////            $contenu->setCreatedAt(new \Datetime());
////            $contenu->setUpdatedAt(new \Datetime());
////            $contenu->setIdEtat(true);
////            // Et on le persiste
//        $em->persist($contenu);
////
//        $em->flush();
    }
 
    return true;

  }

}
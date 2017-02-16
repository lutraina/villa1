<?php

namespace Blog\IntegrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Blog\IntegrationBundle\Antispam\Antispam;

class IndexController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction()
    {
      $antispamFormat = $this->container->getParameter('format_champ_integer2');
      $logger = $this->get('logger');
      $antispam = $this->get('integration.antispam');
      
      $value = 12345;
      if ($antispam->isInteger($logger, $value, $antispamFormat)) {
        $logger->info('é integer');
        return new Response('é integer');
      } else {
        return new Response('nao é integer');  
      }
      
      
        return $this->render('BlogIntegrationBundle:Index:index.html.twig');
    }
}

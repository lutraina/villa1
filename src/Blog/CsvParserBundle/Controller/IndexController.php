<?php

namespace Blog\CsvParserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{
    /**
     * @Route("/import-csv")
     */
    public function indexAction()
    {
        
        $form = $this->createFormBuilder()
                ->add('nom', 'file', array('label' => 'File to Submit'))
                ->getForm();

        // Check if we are posting stuff
        if ($request->getMethod('post') == 'POST') {
            // Bind request to the form
            $form->bindRequest($request);

            // If form is valid
            if ($form->isValid()) {
                 // Get file
                 $file = $form->get('submitFile');

                 // Your csv file here when you hit submit button
                 $file->getData();
            }

         }

        return $this->render('BlogCsvParserBundle:Index:index.html.twig');
    }
}

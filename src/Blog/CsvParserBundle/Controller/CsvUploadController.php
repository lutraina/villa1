<?php

namespace Blog\CsvParserBundle\Controller;

use Blog\CsvParserBundle\Entity\CsvUpload;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Blog\CsvParserBundle\Parser\Csv\CsvParser\CsvParser;
use Blog\IntegrationBundle\Entity\Contenu;
use Symfony\Component\HttpFoundation\Response;

use Psr\Log\LoggerInterface;

/**
 * Csvupload controller.
 *
 * @Route("csvupload")
 */
class CsvUploadController extends Controller
{
    
    /**
     * Current rows of a ligne du fichier csv
     * @var $currentRows 
     */
    private $currentRows = array();
    
    /**
     * Lists all csvUpload entities.
     *
     * @Route("/", name="csvupload_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $csvUploads = $em->getRepository('BlogCsvParserBundle:CsvUpload')->findAll();

        return $this->render('csvupload/index.html.twig', array(
            'csvUploads' => $csvUploads,
        ));
    }

    /**
     * Creates a new csvUpload entity.
     *
     * @Route("/new", name="csvupload_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $csvUpload = new Csvupload();
        $form = $this->createForm('Blog\CsvParserBundle\Form\CsvUploadType', $csvUpload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $uploadedDirectory = $this->container->getParameter('kernel.root_dir').'/../web/uploads';
            $csv=$csvUpload->getNom();
            /*@var $csv \Symfony\Component\HttpFoundation\File\UploadedFile */
            $csv->move($uploadedDirectory, $csv->getClientOriginalName());
            $originalNom = $csv->getClientOriginalName();
            $csvUpload->setNom($originalNom);
            
            $this->lireCsv($originalNom);
            
                    
            $em->persist($csvUpload);
            $em->flush($csvUpload);
            
            $this->saveRow();
            

            return $this->redirectToRoute('csvupload_show', array('id' => $csvUpload->getId()));
        }

        
        
        return $this->render('csvupload/new.html.twig', array(
            'csvUpload' => $csvUpload,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a csvUpload entity.
     *
     * @Route("/{id}", name="csvupload_show")
     * @Method("GET")
     */
    public function showAction(CsvUpload $csvUpload)
    {
        $deleteForm = $this->createDeleteForm($csvUpload);

        return $this->render('csvupload/show.html.twig', array(
            'csvUpload' => $csvUpload,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing csvUpload entity.
     *
     * @Route("/{id}/edit", name="csvupload_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CsvUpload $csvUpload)
    {
        $deleteForm = $this->createDeleteForm($csvUpload);
        $editForm = $this->createForm('Blog\CsvParserBundle\Form\CsvUploadType', $csvUpload);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('csvupload_edit', array('id' => $csvUpload->getId()));
        }

        return $this->render('csvupload/edit.html.twig', array(
            'csvUpload' => $csvUpload,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a csvUpload entity.
     *
     * @Route("/{id}", name="csvupload_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CsvUpload $csvUpload)
    {
        $form = $this->createDeleteForm($csvUpload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($csvUpload);
            $em->flush($csvUpload);
        }

        return $this->redirectToRoute('csvupload_index');
    }

    /**
     * Creates a form to delete a csvUpload entity.
     *
     * @param CsvUpload $csvUpload The csvUpload entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CsvUpload $csvUpload)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('csvupload_delete', array('id' => $csvUpload->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    /**
     * Updates a file into web/uploads.
     *
     * @Route("/{id}", name="images_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $logger = $this->get('logger');
        $logger->info(__METHOD__);
        $logger->info('kernel.root_dir :' . kernel.root_dir);
        
        $image2 = '';
        $ext = '';
        $em = $this->getDoctrine()->getManager();
        //$homepageSections = $em->getRepository('EmauxBundle:HomepageSections')->find($id);
        $Boutique = $em->getRepository('CsvParserBundle:CsvUpload')->findOneBy(array('id' => $id));
        if($Boutique->getNom()){
          
            $image2 = $Boutique->getNom();
            //$path = $_FILES['image']['name'];
            $ext = pathinfo($image2, PATHINFO_EXTENSION);
            //return new Response($ext);
        }  
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CsvParserBundle:CsvUpload')->find($id);
        $form = $this->createForm(new CsvUploadType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            
                $uploadedDirectory = $this->container->getParameter('kernel.root_dir').'/../web/uploads';
                $image=$entity->getNom();
               
            if($image){
                //return new Response('tem nova img');
                
                /*@var $image \Symfony\Component\HttpFoundation\File\UploadedFile */
                $image->move($uploadedDirectory, $image->getClientOriginalName());
                $entity->setNom($image->getClientOriginalName());
                //return new Response($image);
                    
            } else {
                //return new Response('nao tem nova img');
                $entity->setNom($image2);
            }
                
            $em->persist($entity);
            $em->flush();
            
//            $this->get('session')->setFlash('notice','Uploaded');
            
        }   
             
            //return $this->redirect($this->generateUrl('images_index', array('id' => $entity->getId())));
            return $this->render('csvupload/index.html.twig', array(
            'csvUploads' => '',
        ));
            
    }
    
    /**
     * 
     */
    public function lireCsv($originalNom){
        $logger = $this->get('logger');
        $logger->info(__METHOD__);
        
        
        $row = 1;
        $directory = $this->container->getParameter('kernel.root_dir').'/../web/uploads';
        $logger->info('directory : ' . $directory);
        if (($handle = fopen($directory . '/' . $originalNom, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $logger->info("<p> $num champs à la ligne $row: <br /></p>\n");
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $logger->info($data[$c] . "<br />\n");
                    $this->currentRows[] = $data[$c];
                }
            }
            
            $logger->debug('serialize rows : ' . serialize($this->currentRows));
                    
            fclose($handle);
        }


    }
    
    public function saveRow(){
        $logger = $this->get('logger');
        $logger->info(__METHOD__);
        
        
        //$formatFichier = $this->container->getParameter('format_fichier');
        $formatFichier = '';
        $logger = $this->get('logger');
        $CsvParser = $this->get('blog_csv_parser.parser');
        
        $CsvParser->saveRow2($logger, $this->currentRows, $formatFichier);
//
//        if ($CsvParser->saveRow($logger, $this->currentRows, $formatFichier)) {
////          $logger->info('é integer');
////          return new Response('é integer');
////        } else {
////          return new Response('nao é integer');  
//        } 
        return new Response('insertion en base avec succès');  
      
      
    }
    
}

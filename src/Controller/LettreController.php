<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Lettre;
use App\Entity\Reponse;
use App\Repository\LettreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class LettreController extends AbstractController
{
    /**
     * @Route("/lettre/imp", name="lettre_imp")
     */
    public function listlettre(LettreRepository $repo,$id)
    {
         // Configure Dompdf according to your needs
         $pdfOptions = new Options();
         $pdfOptions->set('defaultFont', 'Arial');

            // Instantiate Dompdf with our options
         $dompdf = new Dompdf($pdfOptions);
            //les parametres passés à index remplacent         $repo=$this->getDoctrine()->getRepository(Lettre::class);
            $lettre=$repo->find($id);
            // Retrieve the HTML generated in our twig file
         $html = $this->renderView('lettre/imprime.html.twig', [
            'controller_name' => 'LettreController',
            'lettre' => $lettre
         ]);

         // Load HTML to Dompdf
         $dompdf->loadHtml($html);

         // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
         $dompdf->setPaper('A4', 'portrait');

         // Render the HTML as PDF
         $dompdf->render();

         // Output the generated PDF to Browser (force download)
         $dompdf->stream("my.pdf", [
             "Attachment" => true
         ]);




    }
    /**
    * @Route("/lettre/liste", name="lettre_liste")
    */
    public function listelettre()
    {   $repo=$this->getDoctrine()->getRepository(Lettre::class);

        $lettres= $repo->findAll();
            // Retrieve the HTML generated in our twig file
        return $this->render('lettre/lettres.html.twig', [
            'controller_name' => 'LettreController',
            'lettres' => $lettres
        ]);




    }
    /**
     * @Route("/", name="home")
     */
    public function index(){
        return $this->render('lettre/home.html.twig');
    }
     /**
     * @Route("/lettre/newLettre", name="newLettre")
     */
    public function create(Request $request , EntityManagerInterface $manager){
        $lettre=new lettre();
        $formLettre = $this->createFormBuilder($lettre)
            ->add('nom')
            ->add('age')
            ->add('adresse')
            ->add('textlettre')
            ->add('imagelettre')
            ->add('save', SubmitType::class,
            [
                'label'=>'Enregistrer'
            ])
            ->getForm();
            $formLettre->handleRequest($request);
            if($formLettre->isSubmitted()&& $formLettre->isValid()){
                $manager->persist($lettre);
                $manager->flush();


                return $this->redirectToRoute('home');
            }


        return $this->render('lettre/createlettre.html.twig',[
            'formLettre'=> $formLettre->createView()
            ]);
    }
    /**
     * @Route("/lettre/{id}", name="show_Lettre")
     */

    public function Show($id){
        $repo = $this->getDoctrine()->getRepository(Lettre::class);

       $lettre=$repo->find($id);
       return $this->render('lettre/show.html.twig', [
           'lettre' => $lettre

        ]);
    }


/**
* @Route("/lettre/ecrirereponse", name="ecrirereponse")
*/
   public function lettrereponse(Request $request , EntityManagerInterface $manager)
   {
       // creates a task object and initializes some data for this example
       $reponse = new Reponse();

       $form = $this->createFormBuilder($reponse)
           ->add('contenu', CKEditorType::class)
           ->add('imagecontenu', FileType::class)
           ->add('save', SubmitType::class, ['label' => 'Editer la lettre'])
           ->getForm();
           $form->handleRequest($request);
           if($form->isSubmitted()&& $form->isValid()){
               $manager->persist($reponse);
               $manager->flush();
               return $this->redirectToRoute('home');
           }
           return $this->render('lettre/ecrirereponse.html.twig',[
            'form'=> $form->createView()
            ]);
}




}
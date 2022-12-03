<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;
use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;



//use Symfony\Component\OptionsResolver\Options;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/AfficheP', name: 'AfficheP')]
    public function AfficheProfil(ProfilRepository $repository){
        //$repo =$this->getDoctrine()->getRepository(Classroom::class);
        $Profil=$repository->findAll();
        return $this->render('profil/AfficheProfil.html.twig',['Profil'=>$Profil]);
    }
    #[Route('/suppP/{id}', name: 'd')]
    function DeleteProfil($id,ProfilRepository $repository){
        $Profil=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Profil);
        $em->flush();
        return $this->redirectToRoute('AfficheP');

    }
    #[Route('/ajoutP')]
    function AjoutProfil(Request $request){
        $Profil=new Profil();
        $form=$this->createForm(ProfilType::class,$Profil);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($Profil);
            $em->flush();
            return  $this->redirectToRoute('AfficheP');
        }
        return $this->render('profil/AjoutProfil.html.twig',['form'=>$form->createView()]);

    }
    #[Route('/updateP/{id}', name: 'update')]
    function updateProfil(ProfilRepository $repository,$id,Request $request){
        $Profil=$repository->find($id);
        $form=$this->createForm(ProfilType::class,$Profil);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheP');
        }
        return $this->render('profil/UpdateProfil.html.twig',['f'=>$form->createView()]);



    }
    /**
     * @param ProfilRepository $repository
     * @return Response
     * @Route ("/PDF",name="PDF")
     */
    public function PublicationPDF(ProfilRepository $repository)
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        //l'image est située au niveau du dossier public
        $png = file_get_contents("sample-image.jpg");
        $pngbase64 = base64_encode($png);

        // Retrieve the HTML generated in our twig file

        $publication = $repository->findAll();
        // Load HTML to Dompdf
        $html = $this->renderView('profil/pdf.html.twig',
            ['titre'=> $publication,
                "img64"=>$pngbase64
            ]);

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("pdf.pdf", [
            "Attachment" => false
        ]);
    }


}


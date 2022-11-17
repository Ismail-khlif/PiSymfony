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


}


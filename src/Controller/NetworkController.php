<?php

namespace App\Controller;

use App\Entity\Network;
use App\Form\NetworkType;
use App\Repository\NetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NetworkController extends AbstractController
{
    #[Route('/network', name: 'app_network')]
    public function index(): Response
    {
        return $this->render('network/index.html.twig', [
            'controller_name' => 'NetworkController',
        ]);
    }

    #[Route('/AfficheN', name: 'AfficheN')]
    public function AfficheNetwork(NetworkRepository $repository){
        //$repo =$this->getDoctrine()->getRepository(Classroom::class);
        $Network=$repository->findAll();
        return $this->render('network/afficheNet.html.twig',['Network'=>$Network]);
    }
    #[Route('/suppN/{id}', name: 'd')]
    function DeleteNetwork($id,NetworkRepository $repository){
        $Network=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Network);
        $em->flush();
        return $this->redirectToRoute('AfficheN');

    }
    #[Route('/ajoutN')]
    function AjoutNetwork(Request $request){
        $Network=new Network();
        $form=$this->createForm(NetworkType::class,$Network);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($Network);
            $em->flush();
            return  $this->redirectToRoute('AfficheN');
        }
        return $this->render('network/addNet.html.twig',['form'=>$form->createView()]);

    }
    #[Route('/updateN/{id}', name: 'update')]
    function updateNetwork(NetworkRepository $repository,$id,Request $request){
        $Network=$repository->find($id);
        $form=$this->createForm(NetworkType::class,$Network);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheN');
        }
        return $this->render('network/UpdateNet.html.twig',['f'=>$form->createView()]);



    }

}

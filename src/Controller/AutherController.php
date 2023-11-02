<?php

namespace App\Controller;
use App\Entity\Auther;
use App\Form\AutherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AutherRepository;
use Symfony\Component\HttpFoundation\Request;
class AutherController extends AbstractController
{
    #[Route('/auther', name: 'app_auther')]
    public function index(): Response
    {
        return $this->render('auther/index.html.twig', [
            'controller_name' => 'AutherController',
        ]);
    }

    #[Route('/Afficher_A', name: 'Afficher_A')]
    public function Afficher_s(AutherRepository $repo): Response
    {
        $resul= $repo->findAll();
        return $this->render('auther/ListAuther.html.twig', [
            'response' => $resul,
        ]);
    }


    #[Route('/add', name: 'add')]
    public function add(Request $request, ManagerRegistry $mr): Response
    {
        
        $auther = new Auther();
        $form = $this->createForm(AutherType::class, $auther);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $em=$mr->getManager();
        $em->persist($auther);
        $em->flush();
  
      
     return $this->redirectToRoute('Afficher_A');
    }
    return $this->render('auther/form.html.twig', [
        'form' => $form->createView(),
    ]);
    }


    #[Route('/rm/{id}', name: 'rm')]
    public function rm(AutherRepository $repo, ManagerRegistry $mr, int $id): Response
    {
        $auth= $repo->find($id);
     
        if(!$auth){
            return new Response('non trouve');
        }

        $em=$mr->getManager();
        $em->remove($auth);
        $em->flush();
  
      //return new Response('c bon supp');
    return $this->redirectToRoute('Afficher_A');
    }

    #[Route('/auther/edit_auther/{id}', name: 'edit_auther', methods: ['GET', 'POST'])]
public function edit(Request $request, AutherRepository $repo, ManagerRegistry $mr, int $id): Response
{
    $auth = $repo->find($id);

    if (!$auth ) {
        // Gérez le cas où l'étudiant n'est pas trouvé, par exemple, redirigez vers une page d'erreur
        return new Response('Étudiant non trouvé');
    }

    $form = $this->createForm(AutherType::class, $auth );
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $mr->getManager();
        $em->flush();

        return $this->redirectToRoute('Afficher_A');
    }

    return $this->render('auther/edit_auther.html.twig', [
        'form' => $form->createView(),
    ]);
}

    
}

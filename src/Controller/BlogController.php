<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\BlogtemplateType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="app_blog")
     */
    public function index(Request $request, UserInterface $User, ManagerRegistry $doctrine): Response
    {
        
        //TODO remove all not finished Blog POST by this user

        $Blog = new Blog();

        $form = $this->createForm(BlogtemplateType::class, $Blog);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $Blog->setActivada(false);
            $Blog->setFinalitzada(false);
            $Blog->setUser($User);
            
            $em = $doctrine->getManager();
            $em->persist($Blog);
            $em->flush();

            return $this->redirectToRoute('entradastep2', [
                'id' => $Blog->getId(),
            ]); 
        }

        return $this->render('blog/index.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function entradasegonpas(Blog $entrada,ManagerRegistry $doctrine){
        if($entrada->getTemplatetype()=="Plantilla1"){
            
        }else if($entrada->getTemplatetype()=="Plantilla1"){

        }
            

        return $this->render('blog/segonpas.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

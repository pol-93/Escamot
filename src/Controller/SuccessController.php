<?php

namespace App\Controller;

use App\Entity\Manifest;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\User\UserInterface;

class SuccessController extends AbstractController
{
   

     public function __construct(Security $security)
     {
        $this->security = $security;
     }

    public function index(Request $request,UserInterface $User, ManagerRegistry $doctrine): Response
    {
       
        $user = $this->security->getUser();

       

        if ($request->isMethod('POST')) {
            $manifest = new Manifest();
            $manifest->setContent($request->request->get('content'));
            $manifest->setUpdatedAt(new DateTime());
            $manifest->setUser($User);
            $em = $doctrine->getManager();
            $em->persist($manifest);
            $em->flush();
            //Session flash
            $session = new Session();
            $session->getFlashBag()->add('Message','manifest actualitzat');
            return $this->redirectToRoute('blogstep2');
        }
        


        $manifest_repo = $doctrine->getRepository(Manifest::class);

        $lastUpdate = $manifest_repo->findBy(array(),array('id'=>'DESC'),1,0);

        $lastUpdate = $lastUpdate[0]->getContent();

        $userManifestUpdates = $user->getManifests()->getIterator();
     
        $userManifestUpdates->uasort(function ($first, $second) {
            return (int) $first->getId() > (int) $second->getId() ? -1 : 1;
        });


        return $this->render('success/index.html.twig', [
            'MyUpdates' => $userManifestUpdates,
            'LatestUpdate' => $lastUpdate
        ]);
    }

   
}

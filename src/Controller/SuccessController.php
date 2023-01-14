<?php

namespace App\Controller;

use App\Entity\Manifest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;

class SuccessController extends AbstractController
{
   

     public function __construct(Security $security)
     {
        $this->security = $security;
     }

    public function index(ManagerRegistry $doctrine): Response
    {

        $user = $this->security->getUser();

        $em = $doctrine->getManager();

        $manifest_repo = $doctrine->getRepository(Manifest::class);

        $lastUpdate = $manifest_repo->findBy(array(),array('id'=>'DESC'),1,0);

        $lastUpdate = $lastUpdate[0]->getContent();

        $userManifestUpdates = $user->getManifests();
        
        $MyManifestsArr = [];
        
        
        foreach($user->getManifests() as $manifest){
            array_push($MyManifestsArr, $manifest->getContent());
        }
            
        
    
    
        return $this->render('success/index.html.twig', [
            'MyUpdates' => $MyManifestsArr,
            'LatestUpdate' => $lastUpdate
        ]);
    }
}

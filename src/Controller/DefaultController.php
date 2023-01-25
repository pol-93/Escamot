<?php

namespace App\Controller;

use App\Entity\Manifest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="app_default")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $manifest_repo = $doctrine->getRepository(Manifest::class);
        $lastUpdate = $manifest_repo->findBy(array(),array('id'=>'DESC'),1,0);
        $lastUpdate = $lastUpdate[0]->getContent();

        return $this->render('default/index.html.twig', [
            'LatestUpdate' => $lastUpdate
        ]);
    }
}

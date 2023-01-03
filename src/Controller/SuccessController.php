<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SuccessController extends AbstractController
{
   

     public function __construct(Security $security)
     {
        $this->security = $security;
     }

    public function index(): Response
    {

        $user = $this->security->getUser();

        
        
        return $this->render('success/index.html.twig', [
            'controller_name' => 'SuccessController',
        ]);
    }
}

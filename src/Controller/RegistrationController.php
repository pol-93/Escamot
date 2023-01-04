<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Entity\User;
use App\Form\RegisterType;

class RegistrationController extends AbstractController
{
   
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $user->setRoles(['ROLE_USER']);
            $user->setActive(false);
            $encoded = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            //return $this->redirectToRoute('success');
            $session = new Session();
            $session->getFlashBag()->add('Message',"Un administrador haura d'aporbar la teva solicitud");
            return $this->redirectToRoute('registration');
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

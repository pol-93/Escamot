<?php

namespace App\Controller;

use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
            // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    
    }

    public function check2fa(GoogleAuthenticatorInterface $authenticator, TokenStorageInterface $storage)
    {
        
        $qrCode = $authenticator->getQRContent($storage->getToken()->getUser());

        $url = "https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl=".$qrCode;

        return $this->render('security/2fa.html.twig', [
            'qrCode' => $url,
            
        ]);
    
    }
}

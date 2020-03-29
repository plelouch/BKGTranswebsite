<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecurityController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()){
            return $this->redirectToRoute('homeadmin');
        }
        return $this->render('admin/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/admin/logout", name="admin_app_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/admin/profile", name="admin_security_account")
     */
    public function index()
    {
        return $this->render('admin/security/account.html.twig', [
            'controller_name' => 'AdminSecurityController',
        ]);
    }
}

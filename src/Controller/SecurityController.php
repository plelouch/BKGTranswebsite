<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\UpdatePassword;
use App\Entity\User;
use App\Form\ClientType;
use App\Form\RegisterType;
use App\Form\UpdatePasswordType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
         if ($currentUser) {
             if($currentUser->getRoles() === ["ROLE_USER"]){
                 return $this->redirectToRoute('homepage');
             }

         }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setRoles(['ROLE_USER'])
                ->setPassword($hash)
            ;
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_client', ['id' => $user->getId()]);
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/user/{id}/client/register", name="app_client")
     */
    public function client(Request $request, ObjectManager $manager, User $user): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $client->setUser($user);
            $manager->persist($client);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/client.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/client/account", name="app_account")
     */
    public function account(): Response
    {
        return $this->render('security/account.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
 * @Route("/user/client/{id}/profile", name="app_profile")
 */
    public function profile(Client $client, Request $request): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_account');
        }
        return $this->render('security/profile.html.twig', [
            'client' => $client,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/password-update", name="app_update_password")
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $updatePassword = new UpdatePassword();
        $user = $this->getUser();

        $form = $this->createForm(UpdatePasswordType::class, $updatePassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if(!password_verify($updatePassword->getOdlPassword(), $user->getPassword())){
                $form->get('odlPassword')->addError(new FormError("Le mots de passe saisir ne correspond pas a votre mots de passe actuel!"));
            }else{
                $hash = $encoder->encodePassword($user, $updatePassword->getNewPassword());
                $user->setPassword($hash);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return  $this->redirectToRoute('app_account');
            }
        }
        return $this->render('security/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

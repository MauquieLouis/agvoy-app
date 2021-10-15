<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RoomRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $rR;
    public function __construct(RoomRepository $rR){
        $this->rR = $rR;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $listeRooms = $this->rR->findAll();
        return $this->render('security/index.html.twig', [
            'listeRooms' => $listeRooms,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/offres", name="mesoffres", methods={"GET"})
     */
    public function mesOffres() : Response
    {
        $user = $this->getUser();
//         dd($user);
        $owner = $user->getOwner();
        dd($owner);
        $rooms = $this->getUser()->getOwner()->getRooms();
        dd($rooms);
    }
}

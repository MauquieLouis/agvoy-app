<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
// use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
//             dd($form);
            if($form->get('plainPassword')->getData() != $form->get('confirmPassword')->getData()){
                //Add flash Message
                $this->addFlash('warning', 'Les mots de passe doivent être les mêmes.');
                return $this->redirectToRoute("app_register");
            }
            $user->setPassword(
            $userPasswordEncoderInterface->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $roles = $form->get('roles')->getData();
            switch($roles){
                case 'ROLE_OWNER':
                    $user->setRoles(['ROLE_OWNER']);
                break;
                case 'ROLE_CLIENT':
                    $user->setRoles(['ROLE_CLIENT']);
                break;
                case 'BOTH':
                    $user->setRoles(['ROLE_OWNER','ROLE_CLIENT']);
                break;
                default:
                break;
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
//             $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                 (new TemplatedEmail())
//                     ->from(new Address('mailer.agvoy@gmail.com', 'AgVoy Bot'))
//                     ->to($user->getEmail())
//                     ->subject('Please Confirm your Email')
//                     ->htmlTemplate('registration/confirmation_email.html.twig')
//             );
            // do anything else you need here, like send an email
            //return $this->redirectToRoute(('home'));
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
//     public function verifyUserEmail(Request $request): Response
//     {
//         $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

//         // validate email confirmation link, sets User::isVerified=true and persists
//         try {
//             $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
//         } catch (VerifyEmailExceptionInterface $exception) {
//             $this->addFlash('verify_email_error', $exception->getReason());

//             return $this->redirectToRoute('app_register');
//         }

//         // @TODO Change the redirect on success and handle or remove the flash message in your templates
//         $this->addFlash('success', 'Your email address has been verified.');

//         return $this->redirectToRoute('app_register');
//     }
}

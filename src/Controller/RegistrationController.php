<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

use PHPMailer\PHPMailer\PHPMailer;
use Twig\Environment;

class RegistrationController extends AbstractController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        UserAuthenticatorInterface $userAuthenticator,
        LoginFormAuthenticator $formLoginAuthenticator,
        VerifyEmailHelperInterface $verifyEmailHelper,
        MailerInterface $mailer
        ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //Make the signature url
            $signatureComponents = $verifyEmailHelper->generateSignature(
                'app_verify_email',
                $user->getId(),
                $user->getEmail(),
                ['id' => $user->getId()]
            );
            $verificationUrl = $signatureComponents->getSignedUrl();
            
            //PHP mailer
            $mailer = new PHPMailer();
            $mailer->isSMTP();
            $mailer->Mailer = 'smtp';
            $mailer->Host = 'mail.smtp2go.com';
            $mailer->SMTPAuth = true;
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 2525;
            $mailer->Username = 'bloktevents.com';
            $mailer->Password = 'UGESswGi2HqnmYKV';
    
            $mailer->setFrom('thomas.austin@bloktevents.com', 'Mail Bot');
            $mailer->addAddress($user->getEmail());     //Add a recipient
    
            $mailer->isHTML(true);   
            $mailer->msgHTML(($this->twig->render('email/verify-email.html.twig', [
                'verificationURL' => $verificationUrl
            ])));  
            
            $mailer->send();
            // //Send the email
            // $email = (new Email())
            //     ->from('mailer@tradetracker.com')
            //     ->to('you@example.com')
            //     ->addTo($user->getEmail())
            //     ->subject('Please confirm your email address')
            //     ->text('Confirm your email at: '.$signatureComponents->getSignedUrl());

            // try {
            //     $mailer->send($email);
            // } catch (TransportExceptionInterface $e) {
            //     // some error prevented the email sending; display an
            //     var_dump($e->getMessage());die();
            // }

            $this->addFlash('success', 'Please check your emails.');


            // //Log user in
            // $userAuthenticator->authenticateUser(
            //     $user,
            //     $formLoginAuthenticator,
            //     $request
            // );

            return $this->redirectToRoute('app_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify", name="app_verify_email")
     */
    public function verifiyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }

        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail()
            );
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('error', $e->getReason());
            return $this->redirectToRoute('app_register');
        }

        $user->setIsVerified(true);
        $entityManager->flush();
        $this->addFlash('success', 'Account Verified! You can now log in.');
        return $this->redirectToRoute('app_login');
    }
}

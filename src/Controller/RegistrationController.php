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

class RegistrationController extends AbstractController
{
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
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '0f4175c037c895';
            $phpmailer->Password = '40da6acc0876cb';

            $phpmailer->setFrom('mailer@tradetracker.com', 'Mail Bot');
            $phpmailer->addAddress($user->getEmail());     //Add a recipient

            $phpmailer->isHTML(true);                                  //Set email format to HTML
            $phpmailer->Subject = 'Verify your account';
            $phpmailer->Body = "Welcome! 
                                <br/>
                                Please verify your acccount by clicking the link below
                                <br/>
                                <a>$verificationUrl</a>";
            $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $phpmailer->send();
            var_dump("sent");die();
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

            $this->addFlash('success', 'Confirm your email at: '. $signatureComponents->getSignedUrl());


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

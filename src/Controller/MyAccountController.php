<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MyAccountController extends AbstractController
{

    private $security;
    private $userRepository;

    public function __construct(
        Security $security,
        UserRepository $userRepository
    ) {
        $this->security = $security;
        $this->userRepository =  $userRepository;
    }

    /**
     * @Route("/myaccount", name="app_my_account")
     */
    public function index(Request $request): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->add($user, true);
            dump($user);
            return $this->redirectToRoute('app_my_account', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('my_account/index.html.twig', [
            'controller_name' => 'MyAccountController',
            'userForm' => $form->createView()
        ]);
    }
}

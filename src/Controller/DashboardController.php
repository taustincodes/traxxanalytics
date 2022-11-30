<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TradeRepository;


class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_index")
     */
    public function index(TradeRepository $tradeRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'trades' => $tradeRepository->findByUserId(1)

        ]);
    }
}

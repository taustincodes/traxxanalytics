<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TradeRepository;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_index")
     */
    public function index(TradeRepository $tradeRepository, Security $security): Response
    {
        //TODO: get trades in order of exit date descending
        $trades = $tradeRepository->findByUserId($security->getUser()->getId());
        $strategies = null;
        
        // var_dump($trades);die();
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'trades' => $trades,
            'strategies' => $strategies
        ]);
    }
}

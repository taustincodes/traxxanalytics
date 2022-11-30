<?php

namespace App\Controller;

use App\Entity\Trade;
use App\Form\TradeType;
use App\Repository\TradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trade")
 */
class TradeController extends AbstractController
{
    /**
     * @Route("/", name="app_trade_index", methods={"GET"})
     */
    public function index(TradeRepository $tradeRepository): Response
    {
        return $this->render('trade/index.html.twig', [
            'trades' => $tradeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_trade_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TradeRepository $tradeRepository): Response
    {
        $trade = new Trade();
        $form = $this->createForm(TradeType::class, $trade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trade->setUserId(999);
            $tradeRepository->add($trade, true);

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trade/new.html.twig', [
            'trade' => $trade,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_trade_show", methods={"GET"})
     */
    public function show(Trade $trade): Response
    {
        return $this->render('trade/show.html.twig', [
            'trade' => $trade,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_trade_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trade $trade, TradeRepository $tradeRepository): Response
    {
        $form = $this->createForm(TradeType::class, $trade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tradeRepository->add($trade, true);

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trade/edit.html.twig', [
            'trade' => $trade,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_trade_delete", methods={"POST"})
     */
    public function delete(Request $request, Trade $trade, TradeRepository $tradeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trade->getId(), $request->request->get('_token'))) {
            $tradeRepository->remove($trade, true);
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}

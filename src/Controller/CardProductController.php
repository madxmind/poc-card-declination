<?php

namespace App\Controller;

use App\Repository\CardProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/card-product")
 */
class CardProductController extends AbstractController
{
    /**
     * @Route("/", name="card_product_index", methods={"GET"})
     */
    public function index(CardProductRepository $cardProductRepository): Response
    {
        return $this->render('card_product/index.html.twig', [
            'cardProducts' => $cardProductRepository->findAll(),
        ]);
    }
}

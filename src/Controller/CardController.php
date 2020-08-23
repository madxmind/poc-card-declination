<?php

namespace App\Controller;

use App\Repository\ProductDeclinationRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function card(
        ProductRepository $productRepository,
        ProductDeclinationRepository $productDeclinationRepository
    ) {
        $product = $productRepository->find(1);
        $productDeclinations = $productDeclinationRepository->findBy(['product' => $product], ['product' => 'ASC']);

        foreach ($productDeclinations as $productDeclination) {
            dump($productDeclination->getDeclinations());
        }

        dd($productDeclinations);



        return $this->render('card/index.html.twig', [
            'product_declinations' => $productDeclinations,
        ]);
    }
}

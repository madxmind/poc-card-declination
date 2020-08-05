<?php

namespace App\DataFixtures;

use App\Entity\CardProduct;
use App\Entity\Declination;
use App\Entity\DeclinationCategory;
use App\Entity\Product;
use App\Entity\ProductDeclination;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $userPasswordEncoderInterface;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;
    }

    public function load(ObjectManager $manager)
    {
        $declinationsArray = [
            'Taille' => ['S', 'M', '2xl'],
            'Couleur' => ['Bleu', 'Rouge', 'Vert fluo'],
        ];

        $products = [];
        for ($i = 1; $i <= 3; $i++) {
            $product = new Product();
            $product->setName('Produit ' . $i)
                ->setPrice($i * 10)
                ->setQuantity($i * 5);
            $products[] = $product;
            $manager->persist($product);
        }

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail('email' . $i . '@gmail.com')
                ->setPassword($this->userPasswordEncoderInterface->encodePassword($user, 'password'));
            $users[] = $user;
            $manager->persist($user);
        }

        $declinations = [];
        $productDeclinations = [];
        foreach ($declinationsArray as $k => $v) {
            $declinationCategory = new DeclinationCategory();
            $declinationCategory->setReference($k);
            $manager->persist($declinationCategory);
            foreach ($v as $k2 => $v2) {
                $declination = new Declination();
                $declination->setDeclinationCategory($declinationCategory)
                    ->setName($v2);
                $declinations[] = $declination;
                $manager->persist($declination);

                foreach ($products as $product) {
                    $productDeclination = new ProductDeclination();
                    $productDeclination->setPrice(rand($product->getPrice() * 0.5, $product->getPrice()))
                        ->setQuantity(rand(0, $product->getQuantity() - 1));
                    $productDeclinations[] = $productDeclination;
                    $manager->persist($productDeclination);
                    for ($i = 1; $i <= 2; $i++) {
                        $product->addProductDeclination($productDeclination);
                    }
                }
            }
        }

        foreach ($productDeclinations as $v) {
            foreach ($declinations as $v2) {
                $v->addDeclination($v2);
            }
        }

        foreach ($users as $v) {
            foreach ($products as $v2) {
                $cardProduct = new CardProduct();
                $cardProduct->setUser($v)
                    ->setProduct($v2)
                    ->setQuantity(rand(1, $v2->getQuantity()));
                $manager->persist($cardProduct);
            }
        }

        $manager->flush();
    }
}

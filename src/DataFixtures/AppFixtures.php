<?php

namespace App\DataFixtures;

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

        foreach ($declinationsArray as $k => $v) {
            $declinationCategory = new DeclinationCategory();
            $declinationCategory->setReference($k);
            $manager->persist($declinationCategory);
            foreach ($v as $k2 => $v2) {
                $declination = new Declination();
                $declination->setDeclinationCategory($declinationCategory)
                    ->setName($v2);
                $manager->persist($declination);

                foreach ($products as $product) {
                    for ($i = 1; $i <= 3; $i++) {
                        $productDeclination = new ProductDeclination();
                        $productDeclination->setPrice($product->getPrice() * 0.8)
                            ->setQuantity($product->getQuantity() - 2);
                        $manager->persist($productDeclination);
                        $product->addProductDeclination($productDeclination);
                    }
                }
            }
        }



        $manager->flush();
    }
}

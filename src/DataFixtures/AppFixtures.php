<?php

namespace App\DataFixtures;

use App\Entity\Attribute;
use App\Entity\AttributeCategory;
use App\Entity\CardProduct;
use App\Entity\Declination;
use App\Entity\DeclinationCategory;
use App\Entity\Product;
use App\Entity\ProductCategory;
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
        $productCategories = [];
        for ($i = 1; $i <= 5; $i++) {
            $productCategory = new ProductCategory();
            $productCategory
                ->setName('Catégorie produit ' . $i)
                ;
            $productCategories[] = $productCategory;
            $manager->persist($productCategory);
        }

        $products = [];
        foreach ($productCategories as $v) {
            for ($i = 1; $i <= 10; $i++) {
                $product = new Product();
                $product
                    ->setName('Produit ' . $i)
                    ->setPrice($i * 10)
                    ->setQuantity($i * 5)
                    ->addProductCategory($v)
                    ;
                $products[] = $product;
                $manager->persist($product);
            }
        }

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setEmail('email' . $i . '@gmail.com')
                ->setPassword($this->userPasswordEncoderInterface->encodePassword($user, 'password'))
                ;
            $users[] = $user;
            $manager->persist($user);
        }

        foreach ($users as $v) {
            foreach ($products as $v2) {
                $cardProduct = new CardProduct();
                $cardProduct
                    ->setUser($v)
                    ->setProduct($v2)
                    ->setQuantity(rand(1, $v2->getQuantity()))
                    ;
                $manager->persist($cardProduct);
            }
        }

        $attributeCategories = [];
        for ($i = 1; $i <= 3; $i++) {
            $attributeCategory = new AttributeCategory();
            $attributeCategory
                ->setName('Catégorie attribut ' . $i)
                ;
            $attributeCategories[] = $attributeCategory;
            $manager->persist($attributeCategory);
        }

        $attributes = [];
        foreach ($attributeCategories as $v) {
            for ($i = 1; $i <= 3; $i++) {
                $attribute = new Attribute();
                $attribute
                    ->setName('attribut ' . $i)
                    ->setAttributeCategory($v)
                    ;
                $attributes[] = $attribute;
                $manager->persist($attribute);
            }
        }

        $manager->flush();
    }
}

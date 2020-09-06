<?php

namespace App\DataFixtures;

use App\Entity\Attribute;
use App\Entity\AttributeCategory;
use App\Entity\AttributeCategoryGroup;
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
        for ($i = 1; $i <= 3; $i++) {
            $productCategory = new ProductCategory();
            $productCategory
                ->setName('CatProd ' . $i)
                ;
            $productCategories[] = $productCategory;
            $manager->persist($productCategory);
        }

        $products = [];
        for ($i = 1; $i <= 3; $i++) {
            $product = new Product();
            $product
                ->setName('Produit ' . $i)
                ->setDescription('Description HTML ' . $i)
                ->setPrice($i * 10)
                ->setQuantity($i * 5)
                ->setAcceptOrderOutOfStock(($i > 1) ? 1 : 0)
                ->setMinimalQuantity(($i == 1) ? 5 : null)
                ->addProductCategory($productCategories[$i-1])
                ;
            $products[] = $product;
            $manager->persist($product);
        }

        $users = [];
        for ($i = 1; $i <= 3; $i++) {
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


        $attributeCategoryGroupsArray = [
            'image' => 'Image',
            'select' => 'Liste déroulante',
        ];
        $attributeCategoryGroups = [];
        foreach ($attributeCategoryGroupsArray as $attributeCategoryGroupKey => $attributeCategoryGroupArray) {
            $attributeCategoryGroup = new AttributeCategoryGroup();
            $attributeCategoryGroup
                ->setName($attributeCategoryGroupArray)
                ->setReference($attributeCategoryGroupKey)
                ;
            $manager->persist($attributeCategoryGroup);
            $attributeCategoryGroups[] = $attributeCategoryGroup;
        }

        $attributesArray = [
            'color' => ['blue', 'green', 'red'],
            'size' => ['S', 'M', 'XXL'],
            'model' => ['v1', 'v2', 'v999'],
        ];
        $attributeCategories = $attributes = [];
        foreach ($attributesArray as $attributeCategoryKey => $attributeArray) {
            $attributeCategory = new AttributeCategory();
            $attributeCategory
                ->setName($attributeCategoryKey)
                ->setAttributeCategoryGroup($attributeCategoryGroups[$attributeCategoryKey == 'color' ? 0 : 1])
                ;
            $attributeCategories[] = $attributeCategory;
            $manager->persist($attributeCategory);

            foreach ($attributeArray as $attributeKey) {
                $attribute = new Attribute();
                $attribute
                    ->setName($attributeKey)
                    ->setAttributeCategory($attributeCategory)
                ;
                $attributes[] = $attribute;
                $manager->persist($attribute);
            }
        }

        $manager->flush();
    }
}

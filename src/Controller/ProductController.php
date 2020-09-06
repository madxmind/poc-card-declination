<?php

namespace App\Controller;

use App\Entity\AttributeCategory;
use App\Entity\Product;
use App\Entity\ProductDeclination;
use App\Form\ProductType;
use App\Repository\AttributeCategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    private $attributeCategoryRepository;

    public function __construct(AttributeCategoryRepository $attributeCategoryRepository)
    {
        $this->attributeCategoryRepository = $attributeCategoryRepository;
    }

    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'product_declinations' => $product->getProductDeclinations()->toArray(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($product, $request, $form);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }


    /**
     * @Route("/attribute/{product}", name="select-attributes", options={"expose"=true})
     */
    public function selectAttributes(
        Product $product,
        Request $request,
        AttributeCategoryRepository $attributeCategoryRepository
    ): JsonResponse
    {
        $attributesArray = $this->getArrayAttributesFromNextAttributeCategory(
            $product, $request->query->get('attributeCategoryId', null),
            $request->query->get('attributesString', '') // attributesString: 1-2|2-11|3-73
        );

        return $this->json([
            'html' => $attributesArray['attributes'] ? $this->render("product/_attribute_category.html.twig", [
                'attributeCategory' => $attributesArray['attributeCategory'],
                'attributes' => $attributesArray['attributes'],
                'product' => $product,
            ])->getContent() : '',
            'attributeCategoryId' => $attributesArray['attributeCategory'] ? $attributesArray['attributeCategory']->getId() : '',
        ], 200);
    }

    /**
     * @Route("/attribute/{product}/{attributesString}", name="details-declination", options={"expose"=true})
     */
    public function detailsDeclination(
        Product $product,
        String $attributesString
    ): JsonResponse
    {
        $productDeclination = $this->getDeclinationFromAttributes($product, $attributesString);

        return $this->json([
            'html_price' => $productDeclination ? $this->render("product/_product_price.html.twig", [
                'product' => $product,
                'productDeclination' => $productDeclination,
            ])->getContent() : '',
            'quantity' => ($productDeclination and $productDeclination->getQuantity()) ?? $product->getQuantity(),
        ], 200);
    }



    private function getDeclinationFromAttributes(Product $product, string $attributesString): ?ProductDeclination
    {
        $attributesIdRequired = [];
        $attributesArray = explode('|', $attributesString);
        foreach ($attributesArray as $attributeString) {
            $attributesIdRequired[] = explode('-', $attributeString)[1];
        }

        foreach ($product->getProductDeclinations() as $productDeclination) {
            $validDeclination = true;
            foreach ($productDeclination->getAttributes() as $attribute) {
                if(!in_array($attribute->getId(), $attributesIdRequired)) {
                    $validDeclination = false;
                    break;
                }
            }
            if($validDeclination) {
                return $productDeclination;
            }
        }

        return null;
    }

    private function getArrayAttributesFromNextAttributeCategory(Product $product, ?int $attributeCategoryId, string $attributesString): array
    {
        // TODO: Work with attributeNumber instead of attributeCategoryId

        $attributesIdRequired = [];
        if($attributesString !== '') {
            $attributesArray = explode('|', $attributesString);
            foreach ($attributesArray as $attributeString) {
                $attributeArray = explode('-', $attributeString);
                $attributesIdRequired[] = $attributeArray[1];
                if ($attributeCategoryId == $attributeArray[0]) {
                    break;
                }
            }
        }

        $attributes = [];
        foreach ($product->getProductDeclinations() as $productDeclination) {
            $productDeclinationAttributesId = [];
            foreach ($productDeclination->getAttributes() as $attribute) {
                $productDeclinationAttributesId[] = $attribute->getId();
            }

            $validDeclination = true;
            if(!empty($attributesIdRequired)) {
                foreach ($attributesIdRequired as $attributeIdRequired) {
                    if (!in_array($attributeIdRequired, $productDeclinationAttributesId)) {
                        $validDeclination = false;
                    }
                }
            }
            if($validDeclination) {
                foreach ($productDeclination->getAttributes() as $attribute) {
                    $attributes[$attribute->getAttributeCategory()->getId()][$attribute->getId()] = $attribute;
                }
            }
        }

        if(!$attributeCategoryId) {
            $returnAttributeCategoryId = array_key_first($attributes);
        } else {
            $returnAttributeCategoryId = '';
            $break = false;
            foreach ($attributes as $k => $attribute) {
                if($break) {
                    $returnAttributeCategoryId = $k;
                    break;
                }
                if ($attributeCategoryId == $k) {
                    $break = true;
                }
            }
        }

        return [
            'attributeCategory' => $this->attributeCategoryRepository->find($returnAttributeCategoryId),
            'attributes' => $returnAttributeCategoryId ? $attributes[$returnAttributeCategoryId] : null,
        ];
    }
}

<?php

namespace App\Controller;

use App\Entity\AttributeCategory;
use App\Form\AttributeCategoryType;
use App\Repository\AttributeCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attribute/category")
 */
class AttributeCategoryController extends AbstractController
{
    /**
     * @Route("/", name="attribute_category_index", methods={"GET"})
     */
    public function index(AttributeCategoryRepository $attributeCategoryRepository): Response
    {
        return $this->render('attribute_category/index.html.twig', [
            'attribute_categories' => $attributeCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="attribute_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attributeCategory = new AttributeCategory();
        $form = $this->createForm(AttributeCategoryType::class, $attributeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attributeCategory);
            $entityManager->flush();

            return $this->redirectToRoute('attribute_category_index');
        }

        return $this->render('attribute_category/new.html.twig', [
            'attribute_category' => $attributeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attribute_category_show", methods={"GET"})
     */
    public function show(AttributeCategory $attributeCategory): Response
    {
        return $this->render('attribute_category/show.html.twig', [
            'attribute_category' => $attributeCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attribute_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AttributeCategory $attributeCategory): Response
    {
        $form = $this->createForm(AttributeCategoryType::class, $attributeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attribute_category_index');
        }

        return $this->render('attribute_category/edit.html.twig', [
            'attribute_category' => $attributeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attribute_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AttributeCategory $attributeCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributeCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attributeCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attribute_category_index');
    }
}

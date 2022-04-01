<?php

namespace App\Controller\Admin;

use App\Form\CategoriesType;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/categories', name: 'admin_categories')]
class CategoriesController extends AbstractController
{
    #[Route('/home', name: '_home')]
    public function index(CategoriesRepository $catRepo)
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $catRepo->findAll(),
        ]);
    }
    #[Route('/ajout', name: '_ajout')]
    public function ajoutCategorie(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $categorie = new Categories;

        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($categorie);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_categories_home');
    }

        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/edit/{id}', name: '_edit')]
    public function editCategorie(Request $request, Categories $categorie, EntityManagerInterface $entityManagerInterface)
    {
        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($categorie);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_categories_home');
    }

        return $this->render('admin/categories/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

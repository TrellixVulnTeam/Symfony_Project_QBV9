<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnoncesRepository $annoncesRepository): Response
    {
        $annonce = $annoncesRepository->findAll();
        return $this->render('main/index.html.twig', [
            'annonces' => $annonce,
        ]);
    }
    #[Route('/main/{id}', name: 'app_main_show')]
    public function show( Annonces $annonce): Response
    {
        return $this->render('main/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }
    // #[Route('/main/{id}', name: 'app_main_show')]
    // public function show( Annonces $annonce, int $id, EntityManagerInterface $entityManagerInterface, Categories $categories): Response
    // {
    //     if(is_numeric($id)){

    //         return $this->render('main/show.html.twig', [
    //             'annonce' => $annonce,
    //         ]);
    //     }
    //     else {
    //         $repository = $entityManagerInterface->getRepository(Categories::class);
    //         $annonces = $repository->getAnnonces();
    //         dd($annonces);
    //         return $this->render('main/show.html.twig', [
    //             'annonces' => $annonces,
    //             'category' => $id
    //         ]);
    //     }
    // }
    // #[Route('/{slug}', name: 'app_category')]
    // public function showByCategory( int $slug, EntityManagerInterface $entityManagerInterface): Response
    // {
    //     // if(is_numeric($slug)){

    //     //     return $this->render('main/show.html.twig', [
    //     //         'annonce' => $annonce,
    //     //     ]);
    //     // }
    //     // else {
    //         $repository = $entityManagerInterface->getRepository(Categories::class);
    //         $category = $repository->find($slug);
    //         $annonces = $category->getAnnonces();
    //         dd($annonces);
    //         return $this->render('main/show.html.twig', [
    //             'annonces' => $annonces,
    //             'category' => $slug
    //         ]);
    //     // }
    // }
    
}

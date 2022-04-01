<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecondMainController extends AbstractController
{
    #[Route('/home_users', name: 'app_home_users')]
    public function index(): Response
    {
        return $this->render('homeUsers.html.twig', [
            'controller_name' => 'secondMainController',
        ]);
    }
}

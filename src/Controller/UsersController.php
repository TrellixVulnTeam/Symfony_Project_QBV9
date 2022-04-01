<?php

namespace App\Controller;

use App\Form\EditProfileType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AnnoncesType;
use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }
    #[Route('/users/annonces/ajout', name: 'users_annonces_ajout')]
    public function ajoutAnnonce(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $annonce = new Annonces;

        $form = $this->createForm(AnnoncesType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $annonce->setUsers($this->getUser());
            $annonce->setActive(false);

            $entityManagerInterface->persist($annonce);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_users');
        }
        return $this->render('users/annonces/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/users/annonces/edit/{id}', name: 'users_annonces_edit')]
    public function editAnnonce(Request $request, EntityManagerInterface $entityManagerInterface, Annonces $annonce)
    {

        $form = $this->createForm(AnnoncesType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $annonce->setUsers($this->getUser());
            $annonce->setActive(false);

            $entityManagerInterface->persist($annonce);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_users');
        }
        return $this->render('users/annonces/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_delete', methods: ['GET'])]
    public function delete(Annonces $annonce, EntityManagerInterface $entityManagerInterface
    ): Response {
       {
            $entityManagerInterface->remove($annonce);
            $entityManagerInterface->flush();
        }

        return $this->redirectToRoute(
            'app_users',
            [],
            Response::HTTP_SEE_OTHER
        );
    }
    #[Route('/users/profile/edit', name: 'users_profile_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $user = $this->getUser();
        $form = $this->createForm(editProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $this->addFlash('message','Profil mis à jour');
            return $this->redirectToRoute('app_users');
        }
        return $this->render('users/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/users/password/edit', name: 'users_password_edit')]
    public function editPassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManagerInterface)
    {
        if($request->isMethod('POST')){
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $user = $this->getUser();
           
            if($request->request->get('pass') == $request->request->get('pass2')){
                    $password = $passwordHasher->hashPassword($user,$request->request->get('pass'));
                    $em->flush();
                    $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                    return $this->redirectToRoute('app_users');
            }else{
                $this->addFlash('error', 'Mots de passe non identiques');
            }
        }
        return $this->render('users/editPassword.html.twig',
        );
    }
}

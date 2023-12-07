<?php

namespace App\Controller;

use App\Form\Type\ProfileType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function index(): Response
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserProfileController',
        ]);
    }

    #[Route('/profile/edit', name: 'app_user_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user, ['user' => $user]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $em->flush();

            return $this->redirectToRoute('app_user_profile');
        }


        return $this->render('user/profile_edit.html.twig', [
            'controller_name' => 'UserProfileController',
            'form' => $form
        ]);
    }
}

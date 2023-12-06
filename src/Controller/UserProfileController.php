<?php

namespace App\Controller;

use App\Form\Type\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
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
    public function edit(): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user, ['user' => $user]);


        return $this->render('user/profile_edit.html.twig', [
            'controller_name' => 'UserProfileController',
            'form' => $form
        ]);
    }
}

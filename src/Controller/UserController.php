<?php

namespace App\Controller;

use App\Entity\Discussion;
use App\Entity\Media;
use App\Entity\SeminarConsultation;
use App\Form\Type\AvatarType;
use App\Form\Type\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function getLastReadLink(): Response
    {
        $result = array_reduce(
            $this
                ->getUser()
                ->getSeminarConsultations()
                ->toArray(),
            function ($out, $sc) {
                if ($out == null)
                    return $sc;
                if ($out->getLastConsultedAt() < $sc->getLastConsultedAt())
                    return $sc;
                else
                    return $out;
            },
            null
        );
        return $this->render('user/lastReadLink.html.twig', ['lastRead' => $result]);;
    }

    #[Route('/espace-apprenant', name: 'app_user_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        $currentReads = $em->getRepository(SeminarConsultation::class)->findBy(['user' => $this->getUser(), 'isFinished' => false]);
        $filteredCurrentReads = array_filter($currentReads, function ($read) {
            return count($read->getFinishedChapters());
        });
        $discuRepo = $em->getRepository(Discussion::class);
        $userQs = $discuRepo->findBy(['user' => $this->getUser()]);
        $last3 = $discuRepo->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->render('user/dashboard.html.twig', [
            'currentReads' => $filteredCurrentReads,
            'userQs' => $userQs,
            'last3' => $last3
        ]);
    }

    #[Route('/mon-profil', name: 'app_user_profile')]
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig');
    }

    #[Route('/mon-profil/editer', name: 'app_user_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user, ['user' => $user]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->flush();

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/profile_edit.html.twig', ['form' => $form]);
    }

    #[Route('/mon-profil/changer-avatar', name: 'app_user_change_avatar')]
    public function changeAvatar(Request $request, EntityManagerInterface $em, Filesystem $filesystem): Response
    {
        $user = $this->getUser();
        $avatar = new Media();
        $form = $this->createForm(AvatarType::class, $avatar);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $previousAvatar = $user->getAvatar();
            if ($previousAvatar && $previousAvatar->getUsesAmount() == 1) {
                $em->remove($previousAvatar);
                $filesystem->remove('uploads/'.$previousAvatar->getUrl());
            }

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = sha1($originalFilename) . '.' . $imageFile->guessExtension();
                $imageFile->move('uploads', $newFilename);

                $avatar->setUrl($newFilename);
                $avatar->setName('Avatar de ' . $user->__toString());
                $avatar->setUploadedBy($user);

                $em->persist($avatar);
                $user->setAvatar($avatar);
            } else {
                $user->setAvatar(null);
            }
            $em->flush();

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/change_avatar.html.twig', ['form' => $form]);
    }
}

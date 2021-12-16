<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\User;
use App\Form\HeroType;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HeroController extends AbstractController
{
    /** @var UserRepository */
    private $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(EntityManagerInterface $objectManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $objectManager->getRepository(User::class);
        $this->userPasswordHasher = $userPasswordHasher;
    }
    /**
     * @Route("/User", name="user_list")
     */
    public function userList(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('hero/index.html.twig', [
            'users' => $users
        ]);
    }
    /**
     * @Route("/User/{id}", name="user_details")
     * @param int $id
     * @return Response
     */
    public function userDetail(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        return $this->render('hero/details.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("/Users/{id}/delete", name="delete_user")
     * @param int $id
     * @return Response
     */
    public function deleteUser(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        $this->userRepository->delete($user);

        return $this->redirectToRoute('user_list');
    }

    /**
     * @Route("create/user", name="user_create")
     * @param Request $request
     * @return Response
     */
    public function createUser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(HeroType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $form->get("password")->getData()));
            $user->setRoles(['ROLE_SUPER_HERO']);
            $this->userRepository->save($user);

            return $this->redirectToRoute('user_list');
        }

        return $this->renderForm('hero/new.html.twig', [
            'form' => $form
        ]);
    }
    /**
     * @Route("Users/{id}/update", name="update_user")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function updateUser(int $id, Request $request): Response
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(HeroType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $form->get("password")->getData()));
            $user->setRoles(['ROLE_SUPER_HERO']);
            $this->userRepository->save($user);

            return $this->redirectToRoute('user_list');
        }

        return $this->renderForm('hero/new.html.twig', [
            'form' => $form
        ]);
    }
}

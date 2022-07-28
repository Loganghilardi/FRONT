<?php

namespace App\Controller;

use App\Service\UserApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function listUsers(UserApiService $userApiService): Response
    {
        try {
            $users = $userApiService->getUsers();

            return $this->render('users/users.html.twig', [
                'users' => $users,
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('login');
            } else if ($e->getCode() !== 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('app_home');
            }

            return $this->redirectToRoute('login');
        }
    }

    #[Route('/users/create', name: 'create_user')]
    public function createUser(Request $request, UserApiService $userApiService): Response
    {
        $isLogged = $userApiService->isLogged();
        if (!$isLogged) {
            $this->addFlash(
                'error',
                'connecte toi hmar'
            );

            return $this->redirectToRoute('login');
        }

        try {
            $form = $this->createFormBuilder()
                ->add('firstName', TextType::class)
                ->add('lastName', TextType::class)
                ->add('dailyConsumption', IntegerType::class)
                ->add('cigarettesPerPack', IntegerType::class)
                ->add('packPrice', IntegerType::class)
                ->add('plainPassword', PasswordType::class)
                ->add('email', EmailType::class)
                ->add('send', SubmitType::class)
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // data is an array with "name", "email", and "message" keys
                $data = $form->getData();
                $userApiService->createUser($data);
                $this->addFlash('success', 'Utilisateur ajouté!');

                return $this->redirectToRoute('users');
            }

            return $this->render('users/manage.html.twig', ['form' => $form->createView()]);
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('login');
            } else if ($e->getCode() !== 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('app_home');
            }

            return $this->redirectToRoute('login');
        }
    }


    #[Route('/users/{id<\d+>}/update', name: 'update_user')]
    public function updateUser(Request $request, UserApiService $userApiService, int $id): Response
    {
        try {
            $user = $userApiService->getUser($id);


            $form = $this->createFormBuilder($user)
                ->add('firstName', TextType::class)
                ->add('lastName', TextType::class)
                ->add('dailyConsumption', IntegerType::class)
                ->add('cigarettesPerPack', IntegerType::class)
                ->add('packPrice', IntegerType::class)
                ->add('email', EmailType::class)
                ->add('send', SubmitType::class)
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // data is an array with "name", "email", and "message" keys
                $data = $form->getData();
                $userApiService->updateUser($id, $data);
                $this->addFlash('success', 'Utilisateur édité!');

                return $this->redirectToRoute('users');
            }

            return $this->render('users/manage.html.twig', ['form' => $form->createView()]);
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('login');
            } else if ($e->getCode() !== 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('app_home');
            }

            return $this->redirectToRoute('login');
        }
    }

    #[Route('/users/{id<\d+>}/delete', name: 'delete_user')]
    public function deleteUser(UserApiService $userApiService, int $id): Response
    {
        try {

            $userApiService->deleteUser($id);
            $this->addFlash('warning', 'Utilisateur supprimé!');

            return $this->redirectToRoute('users');
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('login');
            } else if ($e->getCode() !== 401) {
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );

                return $this->redirectToRoute('app_home');
            }

            return $this->redirectToRoute('login');
        }
    }
}

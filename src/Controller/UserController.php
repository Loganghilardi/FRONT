<?php

namespace App\Controller;

use App\Service\UserApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function login(UserApiService $userApiService): Response
    {
        try {
            $users = $userApiService->getUsers();
            return $this->render('users/users.html.twig', [
                'users' => $users,
            ]);
        } catch (\Exception $e) {
            return $this->redirectToRoute('login');
        }
    }
}

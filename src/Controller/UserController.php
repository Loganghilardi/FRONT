<?php

namespace App\Controller;

use App\Service\UserApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            if($e->getCode() == 401) {
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

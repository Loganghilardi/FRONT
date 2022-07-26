<?php

namespace App\Controller;

use App\Service\AuthApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function logout(AuthApiService $authApiService): Response
    {               
        $authApiService->logout();

        return $this->redirectToRoute('app_home');
    }
}

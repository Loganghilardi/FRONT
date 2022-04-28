<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Service\AuthApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout')]
    public function logout(AuthApiService $authApiService, Request $request): Response
    {               
        $authApiService->logout();
        return $this->redirectToRoute('app_home');
    }
}

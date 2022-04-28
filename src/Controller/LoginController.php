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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthApiService $authApiService, Request $request): Response
    {               
        $success = false;
        
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $success = $authApiService->getToken($form->getData());

            } catch (\Exception $e) {
                throw new BadRequestHttpException('Invalid credentials');
            }
            if ($success) {
                return $this->redirectToRoute('users');
            }
        }

        return $this->render('home/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

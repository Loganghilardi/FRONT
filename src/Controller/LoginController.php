<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Service\AuthApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(
        AuthApiService $authApiService,
        Request $request
    ): Response {
        $success = false;

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $success = $authApiService->login($form->getData());

            if ($success) {
                $this->addFlash('success', 'Vous êtes connectés!');

                return $this->redirectToRoute('users');
            } else {
                $this->addFlash(
                    'error',
                    'Vos identifiants ne sont pas valides!'
                );
                return $this->render('home/login.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        }

        return $this->render('home/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

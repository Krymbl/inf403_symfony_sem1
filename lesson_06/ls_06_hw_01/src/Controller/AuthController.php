<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UserRegistrationDto;
use App\Exception\AuthException\EmailAlreadyTakenException;
use App\Form\UserRegistrationType;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{

    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    #[Route(path: '/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash('error', 'Вы уже вошли');

            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/register', name: 'register', methods: ['GET', 'POST'])]
    public function register(Request $request, Security $security): Response
    {
        if ($this->getUser()) {
            $this->addFlash('error', 'Вы уже вошли');

            return $this->redirectToRoute('home');
        }

        $dto = new UserRegistrationDto();
        $form = $this->createForm(UserRegistrationType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->authService->register($dto);

                $security->login($user);
                $this->addFlash('success', 'Вы успешно зарегестрировались');

                return $this->redirectToRoute('home');
            } catch (EmailAlreadyTakenException $e) {
                $form->get('email')->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/logout', name: 'logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \LogicException('Перехватывается и не выполняется.');
    }
}

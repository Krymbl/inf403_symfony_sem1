<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(#[CurrentUser] User $user): Response
    {
        $name = $user->getName();
        $email = $user->getEmail();

        return $this->render('home.html.twig', [
            'name' => $name,
            'email' => $email,
        ]);
    }
}

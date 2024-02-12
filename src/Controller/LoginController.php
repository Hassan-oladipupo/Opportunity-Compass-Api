<?php

namespace App\Controller;

use App\Security\AccessTokenHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class LoginController extends AbstractController
{
    //Login 
    #[Route('/login', name: 'app_auth_login',  methods: ['GET', 'POST'])]
    public function login(AccessTokenHandler $accessTokenHandler, AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error) {
            $errorMessage = 'Incorrect login details.';
            if (str_contains($error->getMessageKey(), 'Invalid credentials')) {
                $errorMessage = 'Incorrect password.';
            }
            return new JsonResponse(['error' => $errorMessage], 401);
        }

        $user = $this->getUser();
        $token = $accessTokenHandler->createForUser($user);
        return $this->json(['message' => 'Login successful', 'token' => $token], Response::HTTP_OK);
    }



    //Logout
    #[Route('/logout', name: 'app_auth_logout', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        return new JsonResponse(['message' => 'Logout successful.']);
    }
}

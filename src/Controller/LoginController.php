<?php

namespace App\Controller;

use SendGrid;
use App\Entity\User;
use SendGrid\Mail\Mail;
use Psr\Log\LoggerInterface;
use App\Repository\UserRepository;
use App\Security\AccessTokenHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    //Login 

    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }


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

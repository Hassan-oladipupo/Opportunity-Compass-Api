<?php

namespace App\Controller;

use SendGrid;
use App\Entity\User;
use SendGrid\Mail\Mail;
use Psr\Log\LoggerInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    private $logger;
    private $urlGenerator;

    public function __construct(LoggerInterface $logger, UrlGeneratorInterface $urlGenerator)
    {
        $this->logger = $logger;
        $this->urlGenerator = $urlGenerator;
    }

    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserRepository $repo): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $violations = $validator->validate($data);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
            return new JsonResponse(['message' => 'Validation errors', 'errors' => $errors], 400);
        }

        if (empty($data['username']) || empty($data['password'])) {
            return new JsonResponse(['message' => 'Email and password are required.'], 400);
        }

        $email = $data['username'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['message' => 'Invalid email format.'], 400);
        }

        $password = $data['password'];
        if (strlen($password) < 8) {
            return new JsonResponse(['message' => 'Password should be at least 8 characters long.'], 400);
        }

        $existingUser = $repo->findOneBy(['username' => $email]);
        if ($existingUser) {
            return new JsonResponse(['message' => 'Email is already registered.'], 400);
        }




        // Create new user entity
        $user = new User();
        $user->setUsername($data['username']);
        $user->setFirstName($data['firstname']);
        $user->setLastName($data['lastname']);

        // Generate activation token
        $activationToken = bin2hex(random_bytes(32));
        $activationLink = $this->urlGenerator->generate('api_confirm_email', ['id' => $user->getId(), 'token' => $activationToken], UrlGeneratorInterface::ABSOLUTE_URL);
        $user->setConfirmationToken($activationToken);

        // Hash and set password
        $hashedPassword = $userPasswordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Validate user entity
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['message' => 'Validation errors', 'errors' => $errorMessages], 400);
        }

        // Persist user entity
        $entityManager->persist($user);
        $entityManager->flush();

        try {
            // Send email
            $sendgridApiKey = $_ENV['SENDGRID_API_KEY'];
            $sendgrid = new SendGrid($sendgridApiKey);

            $email = new Mail();
            $email->setFrom('store@buildafrica.co', 'Build Africa Store');
            $email->addTo($data['username']);
            $email->setSubject("You're almost done! Activate your account");

            $headerImageUrl = 'https://bastorefiles.s3.amazonaws.com/store/BuildAfricaBanner.jpg';
            $footerImageUrl = 'https://bastorefiles.s3.amazonaws.com/store/Investor-Update-newsletter-footer.jpg';
            $hyperlink = '<a href="' . $activationLink . '"><button style="background-color: #FF0000; color: white; padding: 8px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 14px;">ACTIVATE</button></a>';

            $message = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                        }
                        button {
                            cursor: pointer;
                        }
                    </style>
                </head>
                <body>
                    <img src=\"$headerImageUrl\" alt=\"Header Image\" style=\"width: 100%;\">
                    <p>Dear {$data['firstname']},</p>
                    <p>Thank you for registering. Please click the button below to activate your account:</p>
                    $hyperlink
                    <img src=\"$footerImageUrl\" alt=\"Footer Image\" style=\"width: 100%;\">
                </body>
                </html>
            ";

            $email->addContent("text/html", $message);
            $sendgrid->send($email);

            return new JsonResponse(['message' => 'User Registered successfully.', 'user_id' => $user->getId()], 201);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            return new JsonResponse(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    #[Route('/confirm-email', name: 'api_confirm_email', methods: ['GET'])]
    public function confirmEmail(Request $request, UserRepository $repo, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $userId = $request->query->get('id');
            $token = $request->query->get('confirmation_token');



            if (empty($userId) || empty($token)) {
                return new JsonResponse(['message' => 'Invalid token.'], 400);
            }

            $user = $repo->find($userId);

            if (!$user) {
                return new JsonResponse(['message' => 'User not found.'], 404);
            }

            if ($user->isConfirmed()) {
                return new JsonResponse(['message' => 'Email is already confirmed.'], 400);
            }

            if ($user->getConfirmationToken() !== $token) {
                return new JsonResponse(['message' => 'Invalid token.'], 400);
            }

            // Mark user as confirmed
            $user->setConfirmed(true);
            $user->setConfirmationToken(null);

            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Email confirmed successfully.'], 200);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred during email confirmation: ' . $e->getMessage());
            return new JsonResponse(['message' => 'An error occurred during email confirmation: ' . $e->getMessage()], 500);
        }
    }
}

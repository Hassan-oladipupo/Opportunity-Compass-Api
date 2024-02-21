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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ForgetPasswordController extends AbstractController
{
    //Login 

    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }




    #[Route('/forgot-password', name: 'app_forgot_password', methods: ['POST'])]
    public function forgotPassword(Request $request, ValidatorInterface $validator, UserRepository $repo): JsonResponse
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

        if (empty($data['username'])) {
            return new JsonResponse(['message' => 'Email address is required.'], 400);
        }

        $email = $data['username'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['message' => 'Invalid email format.'], 400);
        }

        // Retrieve user by email
        $user = $repo->findOneBy(['username' => $email]);

        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        // Generate reset token
        $resetToken = md5(uniqid());

        // Set reset token and token expiry in user entity
        $user->setResetToken($resetToken);

        $this->entityManager->persist($user);
        $this->entityManager->flush();


        try {

            // Send reset password email
            $resetUrl = $this->generateUrl('reset_password', ['token' => $resetToken], UrlGeneratorInterface::ABSOLUTE_URL);

            // Create and send reset password email
            $sendgridApiKey = $_ENV['SENDGRID_API_KEY'];
            $sendgrid = new SendGrid($sendgridApiKey);

            $email = new Mail();
            $email->setFrom('store@buildafrica.co', 'Build Africa Store');
            $email->addTo($data['username']);
            $email->setSubject("Reset Your Password");

            $headerImageUrl = 'https://bastorefiles.s3.amazonaws.com/store/BuildAfricaBanner.jpg';
            $footerImageUrl = 'https://bastorefiles.s3.amazonaws.com/store/Investor-Update-newsletter-footer.jpg';
            $hyperlink = '<a href="' .   $resetUrl . '"><button style="background-color: #FF0000; color: white; padding: 8px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 14px;">ACTIVATE</button></a>';

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
                <p>Hi,</p>
                <p>We have received a request to reset the password associated with your account. To proceed with the password reset, please click on the link below:</p>
                <p>$hyperlink</p>
                <p>If you did not request a password reset, please disregard this email and take necessary security measures.</p>
                <p>Please kindly note that link expire within 30mins</p>
                <p>Thank you,</p>
              
                <img src=\"$footerImageUrl\" alt=\"Footer Image\" style=\"width: 100%;\">
            </body>
            </html>
        ";

            $email->addContent("text/html", $message);
            $sendgrid->send($email);

            return $this->json(['message' => 'Reset password email sent'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            return new JsonResponse(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    #[Route('/reset-password-confirm', name: 'app_reset_password_confirm', methods: ['POST'])]
    public function resetPasswordConfirm(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserRepository $repo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userId = $data['user_id'] ?? null;
        $resetKey = $data['reset_key'] ?? null;
        $newPassword = $data['new_password'] ?? null;
        $confirmPassword = $data['confirm_password'] ?? null;

        if (empty($userId) || empty($resetKey) || empty($newPassword) || empty($confirmPassword)) {
            return new JsonResponse(['success' => false, 'message' => 'All fields are required'], 400);
        }

        $user = $repo->find($userId);

        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'User not found'], 404);
        }

        $storedResetKey = $user->getResetToken();
        if ($resetKey !== $storedResetKey) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid reset key'], 400);
        }

        if (strlen($newPassword) < 8) {
            return new JsonResponse(['success' => false, 'message' => 'New password must be at least 8 characters long'], 400);
        }

        if ($newPassword !== $confirmPassword) {
            return new JsonResponse(['success' => false, 'message' => 'New password and confirm password do not match'], 400);
        }

        $encodedPassword = $userPasswordHasher->hashPassword($user, $newPassword);
        $user->setPassword($encodedPassword);

        $user->setResetToken(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => 'Password reset successfully.'], 200);
    }
}

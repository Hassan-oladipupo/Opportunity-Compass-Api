<?php

namespace App\Controller;

use App\Entity\JobPost;
use DateTime;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\UserProfileRepository;
use Psr\Log\LoggerInterface;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileSettingController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/settings/profile', name: 'app_settings_profile', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(
        Request $request,
        UserRepository $repo,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        ManagerRegistry $doctrine,
        SluggerInterface $slugger,
        Security $security,
    ): JsonResponse {

        if (!$security->getUser()) {
            return $this->json(['message' => 'Please sign in to set up your profile.'], 403);
        }


        try {
            /** @var User $user */
            $user = $this->getUser();

            $getUserProfile = $user->getUserProfile() ?? new UserProfile();
            $userProfile = new UserProfile();

            $getUserProfile->setName($request->request->get('name') ?? $getUserProfile->getName());
            $getUserProfile->setWebsiteUrl($request->request->get('websiteUrl') ?? $getUserProfile->getWebsiteUrl());
            $getUserProfile->setCompany($request->request->get('company') ?? $getUserProfile->getCompany());
            $getUserProfile->setLocation($request->request->get('location') ?? $getUserProfile->getLocation());
            $dateOfBirthString = $request->request->get('dateOfBirth');
            $dateOfBirth = DateTime::createFromFormat('Y-m-d', $dateOfBirthString);
            $getUserProfile->setDateOfBirth($dateOfBirth ?? $getUserProfile->getDateOfBirth());

            $resumeFile = $request->files->get('resume');

            $violations = $validator->validate($resumeFile, [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => ['image/jpeg', 'image/png', 'application/pdf', 'application/msword'],
                    'mimeTypesMessage' => 'Please upload a valid image, PDF, or Word document for resume.',
                ]),
            ]);

            if (count($violations) > 0) {
                $errorMessages = [];
                foreach ($violations as $violation) {
                    $errorMessages[] = $violation->getMessage();
                }
                return $this->json(['error' => $errorMessages], Response::HTTP_BAD_REQUEST);
            }

            $resumeFileName = $this->moveUploadedFile($resumeFile, $slugger);

            $getUserProfile->setResume($resumeFileName);

            $errors = $validator->validate($getUserProfile);

            if (count($errors) > 0) {
                return $this->json(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user->setUserProfile($getUserProfile);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($getUserProfile);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Your user profile settings were saved']);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            return new JsonResponse(['message' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //Retrieve user account setting
    #[Route('/settings/profile', name: 'app_settings_retrieve_profile', methods: ['GET'])]
    public function getProfile(SerializerInterface $serializer, Security $security): JsonResponse
    {
        if (!$security->getUser()) {
            return $this->json(['message' => 'Please sign in to retrieve your profile.'], 403);
        }

        try {
            /** @var User $user */
            $user = $this->getUser();
            $getUserProfile = $user->getUserProfile();

            if (!$getUserProfile) {
                return $this->json(['message' => 'User profile not found. Please set up your profile.'], Response::HTTP_NOT_FOUND);
            }


            $serializedProfile = $serializer->serialize($getUserProfile, 'json', ['groups' => 'userProfile']);

            return new JsonResponse($serializedProfile, Response::HTTP_OK, [], true);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            return new JsonResponse(['message' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //set profile image

    #[Route('/settings/profile-image', name: 'app_settings_profile_image', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profileImage(
        Request $request,
        SluggerInterface $slugger,
        UserRepository $repo,
        LoggerInterface $logger,
        ManagerRegistry $doctrine,
        ValidatorInterface $validator
    ): JsonResponse {
        $profileImageFile = $request->files->get('Image');

        if (!$profileImageFile) {
            return new JsonResponse(['error' => 'No image uploaded.'], Response::HTTP_BAD_REQUEST);
        }

        $constraints = [
            new File([
                'maxSize' => '1024k',
                'mimeTypes' => ['image/jpeg', 'image/png'],
                'mimeTypesMessage' => 'Please upload a valid PNG/JPEG image',
            ]),
        ];

        $violations = $validator->validate($profileImageFile, $constraints);

        if (count($violations) > 0) {
            return new JsonResponse(['error' => $violations[0]->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $originalFileName = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFileName);
            $newFileName = $safeFilename . '-' . uniqid() . '.' . $profileImageFile->guessExtension();

            $profileImageFile->move(
                $this->getParameter('profiles_directory'),
                $newFileName
            );

            /** @var User $user */
            $user = $this->getUser();

            $profile = $user->getUserProfile() ?? new UserProfile();
            $profile->setImage($newFileName);
            $user->setUserProfile($profile);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your profile image was updated');

            return new JsonResponse(['message' => 'Your profile image was updated']);
        } catch (FileException $e) {
            $logger->error('Failed to upload profile image: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Failed to upload profile image.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function moveUploadedFile(UploadedFile $file, SluggerInterface $slugger): string
    {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFileName);
        $newFileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getParameter('profiles_directory'), $newFileName);
        } catch (FileException $e) {
            $this->logger->error('Error moving uploaded file: ' . $e->getMessage());
            throw new \Exception('Error moving uploaded file: ' . $e->getMessage());
        }

        return $newFileName;
    }
}

<?php

namespace App\Controller;

use App\Entity\JobPost;
use Psr\Log\LoggerInterface;
use App\Entity\ApplicationForm;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ApplicationFormRepository;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ApplicationFormController extends AbstractController
{
    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    #[Route('/submit/{job}', name: 'app_application_form_controller', methods: ['POST'])]
    public function submit(
        Request $request,
        ApplicationFormRepository $repo,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Security $security,
        JobPost $job,
        SluggerInterface $slugger
    ): JsonResponse {
        try {
            $fullName = $request->request->get('fullName');
            $email = $request->request->get('email');
            $phoneNumber = $request->request->get('phoneNumber');
            $address = $request->request->get('address');
            $applyingPosition = $request->request->get('applyingPosition');
            $desiredSalary = $request->request->get('desiredSalary');
            $yearOfExperience = $request->request->get('yearOfExperience');
            $qualification = $request->request->get('qualification');
            $fieldOfStudy = $request->request->get('fieldOfStudy');
            $relevantSkills = $request->request->get('relevantSkills');

            if (!$security->getUser()) {
                return $this->json(['message' => 'You must be logged in to submit an application.'], Response::HTTP_FORBIDDEN);
            }

            // Deserialize JSON data into ApplicationForm object
            $applicationForm = new ApplicationForm();
            $applicationForm->setFullName($fullName);
            $applicationForm->setEmail($email);
            $applicationForm->setPhoneNumber($phoneNumber);
            $applicationForm->setAddress($address);
            $applicationForm->setApplyingPosition($applyingPosition);
            $applicationForm->setDesiredSalary($desiredSalary);
            $applicationForm->setYearOfExperience($yearOfExperience);
            $applicationForm->setQualification($qualification);
            $applicationForm->setFieldOfStudy($fieldOfStudy);
            $applicationForm->setRelevantSkills($relevantSkills);
            $applicationForm->setApplicant($this->getUser());
            $applicationForm->setRelatedJobPost($job);



            // Validate resume and cover letter files
            $resumeFile = $request->files->get('resume');
            $coverLetterFile = $request->files->get('coverLetter');

            $violations = $validator->validate($resumeFile, new File([
                'maxSize' => '1024k',
                'mimeTypes' => ['image/jpeg', 'image/png', 'application/pdf', 'application/msword'],
                'mimeTypesMessage' => 'Please upload a valid image, PDF, or Word document for resume.',
            ]));

            $violations->addAll($validator->validate($coverLetterFile, new File([
                'maxSize' => '1024k',
                'mimeTypes' => ['image/jpeg', 'image/png', 'application/pdf', 'application/msword'],
                'mimeTypesMessage' => 'Please upload a valid image, PDF, or Word document for cover letter.',
            ])));

            if (count($violations) > 0) {
                $errorMessages = [];
                foreach ($violations as $violation) {
                    $errorMessages[] = $violation->getMessage();
                }
                return $this->json(['error' => $errorMessages], Response::HTTP_BAD_REQUEST);
            }

            // Move and save resume and cover letter files
            $resumeFileName = $this->moveUploadedFile($resumeFile, $slugger);
            $coverLetterFileName = $this->moveUploadedFile($coverLetterFile, $slugger);

            $applicationForm->setResume($resumeFileName);
            $applicationForm->setCoverLetter($coverLetterFileName);

            // Validate application form entity
            $violations = $validator->validate($applicationForm);
            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[] = $violation->getMessage();
                }
                return $this->json(['message' => 'Validation errors', 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Save application form entity
            // $repo->save($applicationForm);
            $this->entityManager->persist($applicationForm);
            $this->entityManager->flush();




            return $this->json(['message' => 'Application  submitted successfully.'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            return $this->json(['message' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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

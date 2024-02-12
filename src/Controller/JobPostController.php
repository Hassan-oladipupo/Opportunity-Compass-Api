<?php

namespace App\Controller;

use App\Entity\JobPost;
use Psr\Log\LoggerInterface;
use App\Repository\JobPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobPostController extends AbstractController
{

    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    //Add a job
    #[Route('/create', name: 'app_add_job', priority: 2, methods: ['POST'])]
    public function addJob(Request $request, JobPostRepository $repo, SerializerInterface $serializer, ValidatorInterface $validator, LoggerInterface $logger, Security $security): JsonResponse
    {

        if (!$security->getUser()) {
            return $this->json(['message' => 'Non-logged-in users are not allowed to add jobs.'], 403);
        }

        try {
            $data = $request->getContent();

            $jobPost = $serializer->deserialize($data, jobPost::class, 'json', ['groups' => 'jobPost']);

            $violations = $validator->validate($jobPost);
            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[] = $violation->getMessage();
                }
                return new JsonResponse(['message' => 'Validation errors', 'errors' => $errors], 422);
            }



            $jobPost->setUser($this->getUser());

            $repo->save($jobPost, true);

            return $this->json(['message' => 'Job added successfully.'], 201);
        } catch (\Exception $e) {
            // Log any errors that occur
            $this->logger->error('An error occurred: ' . $e->getMessage());

            // Return a JSON response indicating an error
            return $this->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    //Get all Jobs
    #[Route('/getall', name: 'app_get_jobs', methods: ['GET'])]
    public function getJobs(JobPostRepository $jobPostRepository, SerializerInterface $serializer): JsonResponse
    {
        try {
            $getJobs = $jobPostRepository->findAll();

            $data = $serializer->serialize($getJobs, 'json', ['groups' => 'jobPost']);

            return new JsonResponse($data, 200, [], true);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());

            return $this->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    //Edit job 
    #[Route('/edit/{job}', name: 'app_edit_job_edit', methods: ['PUT'])]
    public function editBlog(JobPost $job, Request $request, JobPostRepository $repo, SerializerInterface $serializer, ValidatorInterface $validator, LoggerInterface $logger, Security $security): JsonResponse
    {

        if (!$security->getUser()) {
            return $this->json(['message' => 'Non-logged-in users are not allowed to edit jobs.'], 403);
        }

        $data = $request->getContent();

        try {
            $editJobPost = $serializer->deserialize($data, JobPost::class, 'json', [
                AbstractNormalizer::OBJECT_TO_POPULATE => $job
            ]);

            $errors = $validator->validate($editJobPost);

            if (count($errors) > 0) {
                $errorMessages = [];
                /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }

                return $this->json(['errors' => $errorMessages], 422);
            }
            $repo->save($editJobPost, true);
            $jsonResponse = $this->json($editJobPost, 200, [], ['groups' => 'jobPost']);
            return $this->json(['message' => 'Job edit successfully.'], 200);
        } catch (\Exception $e) {
            $logger->error('An error occurred: ' . $e->getMessage());
            return $this->json(['message' => 'An error occurred' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\JobPost;
use Psr\Log\LoggerInterface;
use App\Repository\JobPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
            return $this->json(['message' => 'You must be logged in to add a job.'], 403);
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
    public function editJob(JobPost $job, Request $request, JobPostRepository $repo, SerializerInterface $serializer, ValidatorInterface $validator, LoggerInterface $logger, Security $security): JsonResponse
    {

        if (!$security->getUser()) {
            return $this->json(['message' => 'You must be logged in to edit a job post.'], 403);
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


    //Delete a job

    #[Route('/delete/{id}', name: 'app_delete_job', methods: ['DELETE'])]
    public function deleteJob(int $id, JobPostRepository $repo, security $security, EntityManagerInterface $entityManager,): JsonResponse
    {
        if (!$security->getUser()) {
            return $this->json(['message' => 'You must be logged in to delete a job post.'], 403);
        }
        try {
            $jobPost = $repo->find($id);

            if (!$jobPost) {
                return $this->json(['message' => 'Job post not found.'], 404);
            }

            if ($jobPost->getUser() !== $this->getUser()) {
                return $this->json(['message' => 'You are not authorized to delete this job post.'], 403);
            }

            $entityManager->remove($jobPost);
            $entityManager->flush();

            return $this->json(['message' => 'Job post deleted successfully.'], 200);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());

            return $this->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}

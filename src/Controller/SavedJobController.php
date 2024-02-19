<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\JobPost;
use App\Entity\SavedJob;
use Psr\Log\LoggerInterface;
use App\Repository\UserRepository;
use App\Repository\JobPostRepository;
use App\Repository\SavedJobRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SavedJobController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    //Saved job

    #[Route('/jobs/save/{jobId}', name: 'save_job_post', methods: ['POST'])]
    public function saveJobPost(int $jobId, Security $security, JobPostRepository $jobPostRepository, Request $request, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        if (!$security->getUser()) {
            return $this->json(['message' => 'You must be logged in to save a job post.'], 403);
        }

        try {
            /** @var User $user */
            $user = $this->getUser();

            $jobPost = $jobPostRepository->find($jobId);

            if (!$jobPost) {
                return $this->json(['message' => 'Job post not found.'], 404);
            }

            $existingSavedJob = $doctrine->getRepository(SavedJob::class)->findOneBy(['user' => $user, 'jobPost' => $jobPost]);

            if ($existingSavedJob) {
                return new JsonResponse(['message' => 'Job already saved.'], Response::HTTP_CONFLICT);
            }

            $savedJob = new SavedJob();
            $savedJob->setUser($user);
            $savedJob->setJobPost($jobPost);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($savedJob);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Job post saved successfully']);
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            return new JsonResponse(['message' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/jobs/saved', name: 'get_saved_jobs', methods: ['GET'])]
    public function getSavedJobs(Security $security, SavedJobRepository $savedJobRepository): JsonResponse
    {
        $currentUser = $security->getUser();
        if (!$currentUser) {
            return $this->json(['message' => 'You must be logged in to retrieve saved jobs.'], 403);
        }

        $savedJobs = $savedJobRepository->findSavedJobsByUserId($currentUser->getUserIdentifier());

        $savedJobsData = [];
        foreach ($savedJobs as $savedJob) {
            $jobPost = $savedJob->getJobPost();

            // Skip null job posts
            if (!$jobPost instanceof JobPost) {
                continue;
            }

            $savedJobsData[] = [
                'id' => $jobPost->getId(),
                'title' => $jobPost->getJobTitle(),
                'description' => $jobPost->getJobDescription(),
                'jobLocation' => $jobPost->getJobLocation(),
                'jobRequirement' => $jobPost->getJobRequirement(),
                'jobCategory' => $jobPost->getJobCategory(),
                'createdate' => $jobPost->getCreatedate(),
            ];
        }

        return $this->json($savedJobsData);
    }
}

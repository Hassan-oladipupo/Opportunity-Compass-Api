<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationFormContollerController extends AbstractController
{
    #[Route('/application/form/contoller', name: 'app_application_form_contoller')]
    public function index(): Response
    {
        return $this->render('application_form_contoller/index.html.twig', [
            'controller_name' => 'ApplicationFormContollerController',
        ]);
    }
}

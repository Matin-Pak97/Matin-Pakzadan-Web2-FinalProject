<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private PropertyRepository $propertyRepository;

    public function __construct(
        PropertyRepository $propertyRepository
    )
    {
        $this->propertyRepository = $propertyRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $availableProperties = $this->propertyRepository->findAllAvailableProperty();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $availableProperties,
        ]);
    }
}

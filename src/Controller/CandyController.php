<?php

namespace App\Controller;

use App\Repository\CandyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class CandyController extends AbstractController
{
    #[Route('/candies', name: 'app_candies')]
    public function index(CandyRepository $candyRepository): JsonResponse
    {
        $candies = $candyRepository->findAll();
        return $this->json($candies, 200, [
            'groups' => ['candy:read'],
        ]);
    }
}

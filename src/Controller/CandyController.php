<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Candy;
use App\Repository\CandyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class CandyController extends AbstractController
{

    public function __construct(
        private ValidatorInterface $validator,
        private EntityManagerInterface $em,
        private LoggerInterface $logger,
    )
    {
        // ...
    }


    #[Route('/candies', name: 'app_candies_get_all', methods: ['GET'])]
    public function index(CandyRepository $candyRepository): JsonResponse
    {
        $candies = $candyRepository->findAll();
        return $this->json($candies, 200, [], [
            'groups' => ['candy:read'],
        ]);
    }

    #[Route('/candy/{id}', name: 'app_candies_get_one', methods: ['GET'])]
    public function get(Candy $candy): JsonResponse
    {
        return $this->json($candy, 200, [], [
            'groups' => ['candy:read'],
        ]);
    }

    #[Route('/candies', name: 'app_candies_new', methods: ['POST'])]
    public function new(
        Request $request,
    ): JsonResponse {

        try {
            // On extrait le contenu de la requête HTTP
            $body = json_decode($request->getContent(), true);

            // On commence la création de notre nouvelle entité
            $candy = new Candy();
            $candy->setName($body['name']);
            $candy->setSour($body['isSour']);

            // On vérifie la marque
            if(empty($body['brand']['id']))
                throw new \DomainException("La marque est obligatoire pour créer un bonbon.");

            $brand = $this->em->getRepository(Brand::class)->find($body['brand']['id']);

            if(!$brand)
                throw new \Exception("La marque renseignée n'existe pas.");

            $candy->setBrand($brand);

            // On passe l'entité au validator
            $violations = $this->validator->validate($candy);
            if(count($violations) > 0)
                return $this->json($violations, 500);

            // On persiste la nouvelle entité
            $this->em->persist($candy);
            $this->em->flush();

            // On log la persistence
            $this->logger->info("Un nouveau bonbon vient d'être créé avec l'id #" . $candy->getId());

            return $this->json($candy, 201, [], [
                'groups' => ['candy:read'],
            ]);
        } catch (\Exception $e) {

            // On log l'erreur
            $this->logger->error($e->getMessage());

            return $this->json([
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    #[Route('/candy/{id}', name: 'app_candies_update', methods: ['PUT'])]
    public function edit(
        Request $request,
        int $id,
        ?Candy $candy = null
    ): JsonResponse
    {

        try 
        {

            if(!$candy)
                throw new \Exception("Modification d'un bonbon inexistant." . $id);

            $body = json_decode($request->getContent(), true);

            if(!empty($body['name']) && $body['name'] != $candy->getName())
            {
                $candy->setName($body['name']);
            }

            // On passe l'entité au validator
            $violations = $this->validator->validate($candy);
            if(count($violations) > 0)
                return $this->json($violations, 500);
 
            $this->em->flush();

            return $this->json($candy, 200, [], [
                'groups' => ['candy:read'],
            ]);
        }
        catch(\Exception $e)
        {
            // On log l'erreur
            $this->logger->error($e->getMessage());

            return $this->json([
                'error' => $e->getMessage(),
            ], 500);
        }


    }
}

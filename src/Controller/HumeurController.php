<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Entity\Historique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HumeurController extends AbstractController
{
    #[Route('/api/humeur', name: 'send_humeur', methods: ['POST'])]
    public function sendHumeur(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        if (!isset($data['score'])) {
            return new JsonResponse(['error' => 'Le score est requis'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $historique = new Historique();
        $historique->setHumeur($data['score']);
        $historique->setDateCreation(new \DateTime());
        $historique->setUtilisateur($user);

        $entityManager->persist($historique);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Humeur enregistrée'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/sos', name: 'send_sos', methods: ['POST'])]
    public function sendSOS(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        $alerte = new Alerte();
        $alerte->setUserId($user->getId());
        $alerte->setStatut('EN_COURS');

        $entityManager->persist($alerte);

        $historique = new Historique();
        $historique->setUtilisateur($user);
        $historique->setAlerte($alerte);
        $historique->setDateCreation(new \DateTime());
        $historique->setHumeur($data['score'] ?? null);

        $entityManager->persist($historique);
        $entityManager->flush();

        return new JsonResponse(['status' => 'SOS envoyé'], JsonResponse::HTTP_CREATED);
    }
}

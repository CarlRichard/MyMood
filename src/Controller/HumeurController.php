<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Alerte;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HumeurController extends AbstractController
{
    #[Route('/api/humeur', name: 'send_humeur', methods: ['POST'])]
    public function sendHumeur(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        $historique = new Historique();
        $historique->setHumeur($data['score']);
        $historique->setDateEnvoi(new \DateTime());
        $historique->setUtilisateur($user);

        $entityManager->persist($historique);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Humeur enregistrée'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/sos', name: 'send_sos', methods: ['POST'])]
    public function sendSOS(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();

        $alerte = new Alerte();
        $alerte->setDateEnvoi(new \DateTime());
        $alerte->setStatut(1); // 1 peut signifier "active", par exemple

        $entityManager->persist($alerte);

        $historique = new Historique();
        $historique->setUtilisateur($user);
        $historique->setAlerte($alerte);
        $historique->setDateEnvoi(new \DateTime());

        $entityManager->persist($historique);
        $entityManager->flush();

        return new JsonResponse(['status' => 'SOS envoyé'], JsonResponse::HTTP_OK);
    }
}

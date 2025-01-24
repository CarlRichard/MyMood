<?php
namespace App\Controller;

use App\Entity\Alerte;
use App\Entity\Historique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AlerteController extends AbstractController
{
    #[Route('/api/alertes', name: 'create_sos', methods: ['POST'])]
    public function createSOS(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Crée l'alerte
        $alerte = new Alerte();
        $alerte->setStatut(1); // 1 pour SOS, par exemple
        $alerte->setDateEnvoi(new \DateTime());

        $entityManager->persist($alerte);
        $entityManager->flush(); // Pour obtenir l'ID de l'alerte

        // Crée l'historique associé à l'alerte
        $historique = new Historique();
        $historique->setHumeur($data['score']); // Score d'humeur du SOS
        $historique->setDateEnvoi(new \DateTime());
        $historique->setAlerte($alerte); // Associe l'historique à l'alerte

        $entityManager->persist($historique);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Alerte et historique créés'], JsonResponse::HTTP_OK);
    }
}

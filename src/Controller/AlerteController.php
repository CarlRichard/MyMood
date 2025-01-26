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
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non authentifié'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!isset($data['score'])) {
            return new JsonResponse(['error' => 'Le score est requis'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Crée l'alerte
        $alerte = new Alerte();
        $alerte->setStatut('EN_COURS'); // Statut initial
        $alerte->setDateCreation(new \DateTime());
        $alerte->setUserId($user->getId()); // Récupère l'ID utilisateur

        $entityManager->persist($alerte);
        $entityManager->flush();

        // Crée l'historique associé à l'alerte
        $historique = new Historique();
        $historique->setHumeur($data['score']); // Score d'humeur fourni dans la requête
        $historique->setDateEnvoi(new \DateTime());
        $historique->setUtilisateur($user);
        $historique->setAlerte($alerte); // Associe l'historique à l'alerte

        $entityManager->persist($historique);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Alerte et historique créés'], JsonResponse::HTTP_CREATED);
    }
}

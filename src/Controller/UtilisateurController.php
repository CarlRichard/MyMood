<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur/{id}/role', name: 'update_user_role', methods: ['PUT'])]
    public function updateRole(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            return $this->json(['message' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $nouveauRole = $data['role'] ?? null;

        // Vérification du rôle
        if (!$nouveauRole || !in_array($nouveauRole, ['ROLE_ETUDIANT', 'ROLE_SUPERVISEUR', 'ROLE_ADMIN'])) {
            return $this->json(['message' => 'Rôle invalide ou manquant. Choisissez parmi ROLE_ETUDIANT, ROLE_SUPERVISEUR, ROLE_ADMIN.'], Response::HTTP_BAD_REQUEST);
        }

        try {
            // Mise à jour du rôle
            $utilisateur->updateRole($nouveauRole);

            // Persister et flusher l'entité avec le nouveau rôle
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->json(['message' => 'Rôle mis à jour avec succès'], Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function createUser(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
    
        if (!isset($data['email'], $data['password'], $data['role'])) {
            return new JsonResponse(['message' => 'Email, mot de passe et rôle requis'], 400);
        }
    
        // Vérification du rôle
        $role = $data['role'];
        if (!in_array($role, ['ROLE_ETUDIANT', 'ROLE_SUPERVISEUR', 'ROLE_ADMIN'])) {
            return new JsonResponse(['message' => 'Rôle invalide. Choisissez parmi ROLE_ETUDIANT, ROLE_SUPERVISEUR, ROLE_ADMIN.'], 400);
        }
    
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail($data['email']);

    // Hachage du mot de passe dans le contrôleur
    $hashedPassword = $passwordHasher->hashPassword($utilisateur, $data['password']);
    dump($hashedPassword);
    $utilisateur->setPassword($hashedPassword); // Enregistrement du mot de passe haché

    
    
        // Assigner le rôle spécifié
        $utilisateur->setRoles([$role]);
    
        dump($hashedPassword);

        // Persister l'utilisateur
        $entityManager->persist($utilisateur);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], 201);
    }
}

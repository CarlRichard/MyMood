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
    #[Route('/utilisateur', name: 'create_user', methods: ['POST'])]
    public function createUser(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
    
        // Vérification des paramètres requis
        if (!isset($data['email'], $data['password'], $data['role'], $data['nom'], $data['prenom'])) {
            return new JsonResponse(['message' => 'Email, mot de passe, rôle, nom et prénom requis'], 400);
        }
    
        // Vérification du rôle
        $role = $data['role'];  
        if (!in_array($role, ['ROLE_ETUDIANT', 'ROLE_SUPERVISEUR', 'ROLE_ADMIN'])) {
            return new JsonResponse(['message' => 'Rôle invalide. Choisissez parmi ROLE_ETUDIANT, ROLE_SUPERVISEUR, ROLE_ADMIN.'], 400);
        }
    
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail($data['email']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);

    
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($utilisateur, $data['password']);
        $utilisateur->setPassword($hashedPassword);
    
        // Assigner le rôle spécifié
        $utilisateur->setRoles([$role]);
    
        // Persister l'utilisateur*
        print_r($utilisateur);
        $entityManager->persist($utilisateur);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], 201);
    }
    
    //modifier un utilisateur
    #[Route('/utilisateur/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
    
        // Recherche de l'utilisateur à mettre à jour
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);
    
        // Vérifier si l'utilisateur existe
        if (!$utilisateur) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], 404);
        }
    
        // Vérification des paramètres requis
        if (!isset($data['email'], $data['password'], $data['role'], $data['nom'], $data['prenom'])) {
            return new JsonResponse(['message' => 'Email, mot de passe, rôle, nom et prénom requis'], 400);
        }
    
        // Vérification du rôle
        $role = $data['role'];
        if (!in_array($role, ['ROLE_ETUDIANT', 'ROLE_SUPERVISEUR', 'ROLE_ADMIN'])) {
            return new JsonResponse(['message' => 'Rôle invalide. Choisissez parmi ROLE_ETUDIANT, ROLE_SUPERVISEUR, ROLE_ADMIN.'], 400);
        }
    
        $utilisateur->setEmail($data['email']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);
    
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($utilisateur, $data['password']);
        $utilisateur->setPassword($hashedPassword);
    
        // Assigner le rôle spécifié
        $utilisateur->setRoles([$role]);
    
        // Persister l'utilisateur
        $entityManager->persist($utilisateur);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Utilisateur mis à jour avec succès'], 200);
    }

}

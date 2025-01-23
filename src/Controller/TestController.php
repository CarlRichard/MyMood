<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Utilisateur;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test/hash-password', name: 'test_hash_password')]
    public function testHashPassword(UserPasswordHasherInterface $passwordHasher): Response
    {
        $password = 'monMotDePasse123';
        $hashedPassword = $passwordHasher->hashPassword(new Utilisateur(), $password);

        // Affichez le mot de passe haché dans les logs (dump)
        dump($hashedPassword);

        // Retourne une réponse pour informer que le test a été effectué
        return new Response('Test effectué. Consultez les logs pour le résultat.');
    }
}

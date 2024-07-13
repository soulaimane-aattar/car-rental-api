<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response(null, Response::HTTP_CREATED);
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, UserProviderInterface $userProvider, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $JWTManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $userProvider->loadUserByUsername($data['email']);

        if (!$passwordHasher->isPasswordValid($user, $data['password'])) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $token = $JWTManager->create($user);

        return $this->json(['token' => $token]);
    }
}

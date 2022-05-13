<?php

namespace App\Controller;

use App\Entity\ApiToken;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->json(['error' => 'Request error'], 400);

        $user = $this->getUser();

        $token = implode('-', str_split(hash('sha256', random_bytes(256)), 8));
        $expireAt = (new \DateTime())->modify('+2 hour');

        $tokenEntity = new ApiToken();
        $tokenEntity->setUser($user)
            ->setToken($token)
            ->setExpireAt($expireAt);

        $entityManager->persist($tokenEntity);
        $entityManager->flush();

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'token' => $token,
            'expireAt' => $expireAt,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('should not be reached');
    }
}

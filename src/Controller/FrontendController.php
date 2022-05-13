<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FrontendController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(SerializerInterface $serializer)
    {
        return $this->render('frontend/index.html.twig', [
            'user', $serializer->serialize($this->getUser(), 'json'),
            'username' => $this->getUser() ? $this->getUser()->getEmail() : "",
        ]);
    }
}
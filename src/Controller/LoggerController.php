<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LoggerController extends AbstractController
{
    #[Route('/count')]
    public function count(Request $request): JsonResponse
    {
        return new JsonResponse([
            'counter' => rand(1, 1000),
        ]);
    }
}
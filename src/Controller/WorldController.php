<?php

namespace App\Controller;

use App\Domain\Entity\User;
use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorldController extends AbstractController
{
    public function __construct(private readonly UserService $userService,)
    {
    }

    #[Route('/test', name: 'hello')]
    public function test(): Response
    {
        $user = $this->userService->findUserByLogin('test');

        return $this->json(array_map(static fn(User $user) => $user->toArray(), $user));
    }
}
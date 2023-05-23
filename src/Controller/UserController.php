<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserService $userService): JsonResponse
    {
        // this is for testing and checking the on page
        // $user = $userService->createUser('atit@email.com', 'password', 'atit');
        $users = $userService->getUsers();
        // $user = $userService->getUserByUsername('atit1');
        // $validateUser = $userService->validateUserCredential('atit', 'password');
        // $updateUser = $userService->updateUserCredential('atit', 'password', 'password1');

        return $this->json($users, Response::HTTP_OK, [], [
           ObjectNormalizer::SKIP_NULL_VALUES => true
        ]);
    }
}

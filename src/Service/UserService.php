<?php 

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function createUser(
        string $userEmail, 
        string $password, 
        string $userName
    ): User
    {
        $user = new User();
        $user->setEmail($userEmail);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $password
            )
        );
        $user->setUsername($userName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function getUsers(): array
    {
        // return $this->userRepository->findAll();

        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function getUserByUsername(string $username): ?User 
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username])
            ?? throw new UserNotFoundException(sprintf('User "%s" not found', $username));
        return $user;
    }

    public function validateUserCredential(string $username, string $password): bool
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        if (!$user) {
            return false;
        }
        return $this->userPasswordHasher->isPasswordValid($user, $password);
    }

    public function updateUserCredential(
        string $username, 
        string $password, 
        string $updatedPassword, 
        string $updateUsername = null
    ): ?User
    {
        if (!$this->validateUserCredential($username, $password)) {
            return null;
        }
        $user = $this->getUserByUsername($username);
        if ($user instanceof User) {
            if (!is_null($updateUsername)) {
                $user->setUsername($username);
            }
            
            $user->setPassword($this->userPasswordHasher->hashPassword(
                $user,
                $updatedPassword
            ));
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        
        return $user;
    }

}
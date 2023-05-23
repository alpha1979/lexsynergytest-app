<?php 

declare(strict_types=1);

use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserServiceTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->userPasswordHasher = $this->createMock(UserPasswordHasherInterface::class);
      
    }

    // public function testCreateUser(): void
    // {
    //     $email = 'atit@email.com';
    //     $password = 'password';
    //     $username = 'atit';

    //     $user = new User();
    //     $user->setEmail($email);
    //     $user->setPassword($password);
    //     $user->setUsername($username);
        
    //     $this->entityManager
    //         ->expects($this->once())
    //         ->method('persist')
    //         ->with($user);

    //     $this->entityManager
    //         ->expects($this->once())
    //         ->method('flush');
    //     // dd($user);
    //     $createdUser = $this->getSut()->createUser($email, $password, $username);

    //     $this->assertInstanceOf(User::class, $createdUser);
    //     // $this->assertSame($username, $createdUser->getUsername());
    // }

    public function testGetUsers(): void
    {
        $user1 = new User();
        $user2 = new User();

        $users = [$user1, $user2];

        $this->entityManager->find
            // ->expects($this->once())
            // ->method('getRepository')
            // ->with(User::class)
            // ->willReturnSelf();

        $this->entityManager
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $retrievedUsers = $this->getSut()->getUsers();

        $this->assertSame($users, $retrievedUsers);
    }
    
    private function getSut(): UserService
    {
        return new UserService(
            $this->entityManager,
            $this->userPasswordHasher
        );
    }
}

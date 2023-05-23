<?php 

declare(strict_types=1);

use App\Service\UserService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserServiceTest extends TestCase
{
    private UserPasswordHasherInterface $userPasswordHasher;

    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
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
        
       
    //     $this->userRepository->expects($this->once())->method('save')->with($user, true);
    //     $createdUser = $this->getSut()->createUser($email, $password, $username);

    //     $this->assertInstanceOf(User::class, $createdUser);
    //     // $this->assertSame($username, $createdUser->getUsername());
    // }

    public function testGetUsers(): void
    {
        $user1 = new User();
        $user2 = new User();

        $users = [$user1, $user2];

        $this->userRepository->expects($this->once())->method('findAll')->willReturn($users);
        $retrievedUsers = $this->getSut()->getUsers();

        $this->assertSame($users, $retrievedUsers);
    }
    
    public function testGetUserByUsername(): void
    {
        $username = 'atit';
        $user = new User();
        $this->userRepository->expects($this->once())->method('findOneBy')->with(['username' => $username])->willReturn($user);

        $retrievedUser = $this->getSut()->getUserByUsername($username);
        $this->assertSame($user, $retrievedUser);
    }

    // public function testGetUserByUsernameUserNotFoundException(): void
    // {
    //     $username = 'atit';
    //     $user = new User();
    //     $this->userRepository->expects($this->once())->method('findOneBy')->with(['username' => $username])->willReturn($user);

    //     $this->expectException(UserNotFoundException::class);
    //             $this->getSut()->getUserByUsername('atit1');

    //     $this->expectExceptionMessage('User "atit" not found');
    // }

    private function getSut(): UserService
    {
        return new UserService(
            $this->userRepository,
            $this->userPasswordHasher
        );
    }
}

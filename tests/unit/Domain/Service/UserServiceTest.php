<?php

namespace UnitTests\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\UserRepository;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[CoversClass(UserService::class)]
class UserServiceTest extends TestCase
{
    private const PASSWORD_HASH = 'my_hash';
    private const ROLES = [
        'DEFAULT' => 'ROLE_USER',
        'VIEW' => 'ROLE_VIEW',
        'EDIT' => 'ROLE_EDIT',
    ];

    #[Test]
    #[DataProvider('createTestCases')]
    public function create(CreateUserModel $createUserModel, array $expectedData): void
    {
        $userService = $this->prepareUserService();

        $user = $userService->create($createUserModel);

        $actualData = [
            'login' => $user->getLogin(),
            'passwordHash' => $user->getPassword(),
            'roles' => $user->getRoles(),
        ];

        self::assertInstanceOf(User::class, $user);

        self::assertIsString($actualData['login']);
        self::assertNotEmpty($actualData['login']);
        self::assertSame($expectedData['login'], $actualData['login']);

        self::assertIsString($actualData['passwordHash']);
        self::assertNotNull($actualData['passwordHash']);
        self::assertEquals($expectedData['passwordHash'], $actualData['passwordHash']);

        self::assertIsArray($actualData['roles']);
        self::assertSameSize($expectedData['roles'], $actualData['roles']);
        self::assertEqualsCanonicalizing($expectedData['roles'], $actualData['roles']);
        self::assertContainsOnlyString($actualData['roles']);
    }

    private function prepareUserService(): UserService
    {
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('create')
            ->willReturnCallback(function(User $user) {
                $reflection = (new \ReflectionClass(User::class));
                $idProperty = $reflection->getProperty('id');
                $idProperty->setAccessible(true);
                $idProperty->setValue($user, 1);
                return 1;
            });

        $userPasswordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $userPasswordHasher->expects($this->once())
            ->method('hashPassword')
            ->willReturn(self::PASSWORD_HASH);

        return new UserService($userRepository, $userPasswordHasher);
    }

    public static function createTestCases(): Generator
    {
        yield [
            new CreateUserModel(
                'Viewer 1',
                'ViewerPass',
                ["ROLE_VIEW"]
            ),
            [
                'class' => User::class,
                'login' => 'Viewer 1',
                'passwordHash' => self::PASSWORD_HASH,
                'roles' => [
                    self::ROLES['DEFAULT'],
                    self::ROLES['VIEW'],
                ],
            ]
        ];

        yield [
            new CreateUserModel(
                'Editor 1',
                'EditorPass2',
                ["ROLE_EDIT"]
            ),
            [
                'class' => User::class,
                'login' => 'Editor 1',
                'passwordHash' => self::PASSWORD_HASH,
                'roles' => [
                    self::ROLES['EDIT'],
                    self::ROLES['DEFAULT']
                ],
            ]
        ];
    }

}

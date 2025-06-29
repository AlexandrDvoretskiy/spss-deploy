<?php

namespace Tests\PhpUnit\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\UserRepository;
use Generator;
use Mockery;
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
            'class' => get_class($user),
            'login' => $user->getLogin(),
            'passwordHash' => $user->getPassword(),
            'roles' => $user->getRoles(),
        ];

        self::assertEquals($expectedData, $actualData);
    }

    private function prepareUserService(): UserService
    {
        $userRepository = Mockery::mock(UserRepository::class)->shouldIgnoreMissing();

        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordHasher->shouldReceive('hashPassword')
            ->andReturn(self::PASSWORD_HASH);

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
                    self::ROLES['VIEW'],
                    self::ROLES['DEFAULT'],
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

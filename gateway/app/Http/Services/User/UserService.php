<?php

namespace App\Http\Services\User;

use App\Http\Common\Constants\DB\User\UserTableInterface;
use App\Http\Handlers\LoginHandler;
use App\Http\RepositoryInterfaces\User\UserRepositoryInterface;
use App\Http\ServiceInterfaces\User\UserServiceInterface;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected LoginHandler $loginHandler
    ) {
    }

    /**
     * @throws AuthenticationException
     */
    public function getByEmailAndPassword(string $email, string $password): User|null
    {
        return $this->loginHandler->handle($email, $password);
    }

    public function createUser(array $data): void
    {
        $user = new User([
            UserTableInterface::COLUMN_NAME     => $data['name'],
            UserTableInterface::COLUMN_EMAIL    => $data['email'],
            UserTableInterface::COLUMN_PASSWORD => bcrypt($data['password']),
            UserTableInterface::COLUMN_SERVICES => $data['services'] ?? null,
        ]);

        $this->userRepository->save($user);
    }
}

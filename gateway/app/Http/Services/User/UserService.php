<?php

namespace App\Http\Services\User;

use App\Http\Common\Constants\DB\User\UserTableInterface;
use App\Http\RepositoryInterfaces\User\UserRepositoryInterface;
use App\Http\ServiceInterfaces\User\UserServiceInterface;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @throws AuthenticationException
     */
    public function getByEmailAndPassword(string $email, string $password): mixed
    {
        $user = User::query()
            ->where(UserTableInterface::COLUMN_EMAIL, $email)
            ->first();

        if (isset($user) && Hash::check($password, $user->password)) {
            return $user;
        }

        throw new AuthenticationException('Invalid credentials');
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

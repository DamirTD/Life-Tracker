<?php

namespace App\Models;

use App\Http\Common\Constants\DB\User\UserTableInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property array|null $services
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        UserTableInterface::COLUMN_NAME,
        UserTableInterface::COLUMN_EMAIL,
        UserTableInterface::COLUMN_PASSWORD,
        UserTableInterface::COLUMN_SERVICES,
    ];

    protected $hidden = [
        UserTableInterface::COLUMN_PASSWORD,
        UserTableInterface::COLUMN_REMEMBER_TOKEN,
    ];

    protected function casts(): array
    {
        return [
            UserTableInterface::COLUMN_EMAIL_VERIFIED_AT => 'datetime',
            UserTableInterface::COLUMN_PASSWORD => 'hashed',
            UserTableInterface::COLUMN_SERVICES => 'array',
        ];
    }
}

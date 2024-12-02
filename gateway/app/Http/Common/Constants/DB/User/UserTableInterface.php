<?php

namespace App\Http\Common\Constants\DB\User;

interface UserTableInterface
{
    public const COLUMN_NAME = 'name';
    public const COLUMN_EMAIL = 'email';
    public const COLUMN_EMAIL_VERIFIED_AT = 'email_verified_at';
    public const COLUMN_PASSWORD = 'password';
    public const COLUMN_REMEMBER_TOKEN = 'remember_token';
    public const COLUMN_SERVICES = 'services';
}

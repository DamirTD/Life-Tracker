<?php

namespace App\Http\Common\Constants\DB\User;

interface UserTableInterface
{
    public const TABLE_NAME = 'users';
    public const TABLE_PASSWORD_RESET_TOKENS = 'password_reset_tokens';
    public const TABLE_SESSIONS = 'sessions';

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_EMAIL = 'email';
    public const COLUMN_EMAIL_VERIFIED_AT = 'email_verified_at';
    public const COLUMN_PASSWORD = 'password';
    public const COLUMN_REMEMBER_TOKEN = 'remember_token';
    public const COLUMN_SERVICES = 'services';
    public const COLUMN_CREATED_AT = 'created_at';

    public const COLUMN_IP_ADDRESS = 'ip_address';
    public const COLUMN_USER_AGENT = 'user_agent';
    public const COLUMN_PAYLOAD = 'payload';
    public const COLUMN_LAST_ACTIVITY = 'last_activity';

    public const COLUMN_USER_ID = 'user_id';
}

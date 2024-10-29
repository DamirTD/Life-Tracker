<?php

use App\Http\Common\Constants\DB\User\UserTableInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(UserTableInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id(UserTableInterface::COLUMN_ID);
            $table->string(UserTableInterface::COLUMN_NAME);
            $table->string(UserTableInterface::COLUMN_EMAIL)->unique();
            $table->timestamp(UserTableInterface::COLUMN_EMAIL_VERIFIED_AT)->nullable();
            $table->string(UserTableInterface::COLUMN_PASSWORD);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create(UserTableInterface::TABLE_PASSWORD_RESET_TOKENS, function (Blueprint $table) {
            $table->string(UserTableInterface::COLUMN_EMAIL)->primary();
            $table->string('token');
            $table->timestamp(UserTableInterface::COLUMN_CREATED_AT)->nullable();
        });

        Schema::create(UserTableInterface::TABLE_SESSIONS, function (Blueprint $table) {
            $table->string(UserTableInterface::COLUMN_ID)->primary();
            $table->foreignId(UserTableInterface::COLUMN_USER_ID)->nullable()->index();
            $table->string(UserTableInterface::COLUMN_IP_ADDRESS, 45)->nullable();
            $table->text(UserTableInterface::COLUMN_USER_AGENT)->nullable();
            $table->longText(UserTableInterface::COLUMN_PAYLOAD);
            $table->integer(UserTableInterface::COLUMN_LAST_ACTIVITY)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UserTableInterface::TABLE_NAME);
        Schema::dropIfExists(UserTableInterface::TABLE_PASSWORD_RESET_TOKENS);
        Schema::dropIfExists(UserTableInterface::TABLE_SESSIONS);
    }
};

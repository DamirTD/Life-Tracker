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
        Schema::table(UserTableInterface::TABLE_NAME, function (Blueprint $table) {
            $table->json(UserTableInterface::COLUMN_SERVICES)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(UserTableInterface::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn(UserTableInterface::COLUMN_SERVICES);
        });
    }
};

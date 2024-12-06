<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GatewayUser extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['id', 'name', 'email'];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'user_id');
    }
}

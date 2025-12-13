<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'coins',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_coin');
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandePayment extends Model
{
    protected $fillable = [
        'commande_id',
        'user_id',
        'amount',
        'payment_method',
        'payment_type',
    ];

    /**
     * Relation avec la commande
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero',
        'client',
        'numero_whatsapp',
        'date_depot',
        'date_retrait',
        'heure_retrait',
        'type_lavage',
        'statut',
        'avance_client',
        'total',
        'solde_restant',
        'remise_reduction',
        'original_total',
        'discount_amount',
        'password_client'
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation many-to-many avec Objets
     */
    public function objets()
    {
        return $this->belongsToMany(Objets::class, 'commande_objets', 'commande_id', 'objet_id')
            ->withPivot('quantite', 'description')
            ->withTimestamps();
    }

    /**
     * Relation avec les paiements
     */
    public function payments()
    {
        return $this->hasMany(CommandePayment::class);
    }

    /**
     * Calculer le total des paiements
     */
    public function getTotalPaymentsAttribute()
    {
        return $this->payments()->sum('amount');
    }
}

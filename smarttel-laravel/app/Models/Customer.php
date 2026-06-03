<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'customer_id',
        'gender',
        'senior_citizen',
        'partner',
        'dependents'
    ];
    
    protected $casts = [
        'senior_citizen' => 'boolean'
    ];
    
    /**
     * Relation avec les factures
     */
    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Relation avec le statut d'attrition
     */
    public function churn(): HasOne
    {
        return $this->hasOne(Churn::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Relation avec les services
     */
    public function services(): HasOne
    {
        return $this->hasOne(Service::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Relation avec l'abonnement
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Obtenir toutes les informations du client
     */
    public function getFullProfileAttribute()
    {
        return [
            'customer' => $this,
            'billing' => $this->billings,
            'churn' => $this->churn,
            'services' => $this->services,
            'subscription' => $this->subscription
        ];
    }
    
}
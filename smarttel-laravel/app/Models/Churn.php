<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Churn extends Model
{
    protected $table = 'churns';
    
    protected $fillable = [
        'customer_id',
        'churn_status'
    ];
    
    /**
     * Relation avec le client
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Vérifier si le client a quitté
     */
    public function isChurned(): bool
    {
        return strtolower($this->churn_status) === 'yes';
    }
    
    /**
     * Obtenir le statut formaté
     */
    public function getFormattedStatusAttribute(): string
    {
        return $this->isChurned() ? 'Client perdu' : 'Client actif';
    }
    
    /**
     * Scope pour les clients perdus
     */
    public function scopeChurned($query)
    {
        return $query->where('churn_status', 'Yes');
    }
    
    /**
     * Scope pour les clients actifs
     */
    public function scopeActive($query)
    {
        return $query->where('churn_status', 'No');
    }
}
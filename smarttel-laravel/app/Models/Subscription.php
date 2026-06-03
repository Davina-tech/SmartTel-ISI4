<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    
    protected $fillable = [
        'customer_id',
        'tenure',
        'contract',
        'paperless_billing',
        'payment_method'
    ];
    
    protected $casts = [
        'tenure' => 'integer'
    ];
    
    /**
     * Relation avec le client
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Vérifier si le contrat est à long terme
     */
    public function isLongTermContract(): bool
    {
        return $this->contract === 'Two year';
    }
    
    /**
     * Obtenir la catégorie d'ancienneté
     */
    public function getTenureCategoryAttribute(): string
    {
        if ($this->tenure < 12) return 'Nouveau client';
        if ($this->tenure < 24) return 'Client régulier';
        if ($this->tenure < 48) return 'Client fidèle';
        return 'Client VIP';
    }
    
    /**
     * Vérifier le mode de paiement
     */
    public function isElectronicPayment(): bool
    {
        return in_array($this->payment_method, ['Electronic check', 'Credit card']);
    }
    
    /**
     * Scope pour les contrats mensuels
     */
    public function scopeMonthlyContract($query)
    {
        return $query->where('contract', 'Month-to-month');
    }
    
    /**
     * Scope pour les longs contrats
     */
    public function scopeLongTermContract($query)
    {
        return $query->whereIn('contract', ['One year', 'Two year']);
    }
    
    /**
     * Scope pour la facturation papier
     */
    public function scopePaperBilling($query)
    {
        return $query->where('paperless_billing', 'No');
    }
}
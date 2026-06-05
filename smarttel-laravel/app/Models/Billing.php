<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Billing extends Model
{
    protected $table = 'billings';
    
    protected $fillable = [
        'customer_id',
        'monthly_charges',
        'total_charges'
    ];
    
    protected $casts = [
        'monthly_charges' => 'decimal:2',
        'total_charges' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    /**
     * Relation avec le client
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Calculer les charges annuelles
     */
    public function getAnnualChargesAttribute(): float
    {
        return $this->monthly_charges * 12;
    }
    
    /**
     * Vérifier si le client a des charges élevées
     */
    public function isHighValueCustomer(): bool
    {
        return $this->total_charges > 5000;
    }
}
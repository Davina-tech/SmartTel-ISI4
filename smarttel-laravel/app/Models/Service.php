<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $table = 'services';
    
    protected $fillable = [
        'customer_id',
        'phone_service',
        'multiple_lines',
        'internet_service',
        'online_security',
        'online_backup',
        'device_protection',
        'tech_support',
        'streaming_tv',
        'streaming_movies'
    ];
    
    /**
     * Relation avec le client
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    
    /**
     * Vérifier si le client a un service internet
     */
    public function hasInternetService(): bool
    {
        return $this->internet_service !== 'No';
    }
    
    /**
     * Obtenir tous les services actifs
     */
    public function getActiveServicesAttribute(): array
    {
        $services = [];
        
        if ($this->phone_service === 'Yes') $services[] = 'Phone';
        if ($this->multiple_lines === 'Yes') $services[] = 'Multiple Lines';
        if ($this->hasInternetService()) $services[] = $this->internet_service;
        if ($this->online_security === 'Yes') $services[] = 'Online Security';
        if ($this->online_backup === 'Yes') $services[] = 'Online Backup';
        if ($this->device_protection === 'Yes') $services[] = 'Device Protection';
        if ($this->tech_support === 'Yes') $services[] = 'Tech Support';
        if ($this->streaming_tv === 'Yes') $services[] = 'Streaming TV';
        if ($this->streaming_movies === 'Yes') $services[] = 'Streaming Movies';
        
        return $services;
    }
    
    /**
     * Compter le nombre de services actifs
     */
    public function getServicesCountAttribute(): int
    {
        return count($this->active_services);
    }
    
    /**
     * Scope pour les clients avec internet
     */
    public function scopeWithInternet($query)
    {
        return $query->where('internet_service', '!=', 'No');
    }
}
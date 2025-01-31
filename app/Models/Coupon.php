<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'max_uses',
        'times_used',
        'is_active',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($now < $this->valid_from || ($this->valid_until && $now > $this->valid_until)) {
            return false;
        }

        if ($this->max_uses && $this->times_used >= $this->max_uses) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }
        
        return $amount * ($this->value / 100);
    }
}

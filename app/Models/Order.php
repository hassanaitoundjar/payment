<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_number',
        'customer_email',
        'customer_name',
        'customer_whatsapp',
        'amount',
        'currency',
        'payment_method',
        'status',
        'transaction_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

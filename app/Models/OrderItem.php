<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the menu for the order item.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Calculate subtotal.
     */
    public function calculateSubtotal(): void
    {
        $this->subtotal = $this->quantity * $this->price;
        $this->save();
    }
}
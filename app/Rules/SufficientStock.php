<?php

namespace App\Rules;

use App\Models\Menu;
use App\Models\OrderItem;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SufficientStock implements ValidationRule
{
    /**
     * Create a new rule instance.
     *
     * @param array $items All order items from the request
     * @param int|null $currentOrderId For edit mode: restore previous quantities
     */
    public function __construct(
        protected array $items,
        protected ?int $currentOrderId = null
    ) {
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Calculate total requested quantity per menu
        $requestedQuantities = [];
        foreach ($this->items as $item) {
            $menuId = $item['menu_id'];
            $quantity = $item['quantity'];

            if (!isset($requestedQuantities[$menuId])) {
                $requestedQuantities[$menuId] = 0;
            }
            $requestedQuantities[$menuId] += $quantity;
        }

        // Validate each menu's stock
        $errors = [];
        foreach ($requestedQuantities as $menuId => $requestedQty) {
            $menu = Menu::find($menuId);

            if (!$menu) {
                $errors[] = "Menu dengan ID {$menuId} tidak ditemukan.";
                continue;
            }

            $availableStock = $menu->stock;

            // If editing an order, add back the previous quantities for this menu
            if ($this->currentOrderId) {
                $previousQty = OrderItem::where('order_id', $this->currentOrderId)
                    ->where('menu_id', $menuId)
                    ->sum('quantity');
                $availableStock += $previousQty;
            }

            // Check if stock is sufficient
            if ($availableStock < $requestedQty) {
                if ($availableStock <= 0) {
                    $errors[] = "Menu \"{$menu->name}\" sudah habis (stok kosong).";
                } else {
                    $errors[] = "Stok \"{$menu->name}\" tidak mencukupi. Tersedia: {$availableStock}, diminta: {$requestedQty}.";
                }
            }

            // Check if menu is available
            if (!$menu->is_available) {
                $errors[] = "Menu \"{$menu->name}\" tidak tersedia untuk dipesan.";
            }
        }

        // If there are any errors, fail validation
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $fail($error);
            }
        }
    }
}

<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    /**
     * Process and store a new order.
     *
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data): Order
    {
        return Order::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'area' => $data['area'],
            'address' => $data['address'],
            'notes' => $data['notes'] ?? null,
            'quantity' => $data['quantity'],
            'total_price' => $data['total_price'],
            'status' => 'pending',
        ]);
    }

    /**
     * Send notification to WhatsApp or Admin (Placeholder logic)
     *
     * @param Order $order
     * @return void
     */
    public function notifyAdmin(Order $order): void
    {
        // Here you would implement your notification logic
        // Like sending an SMS, Email, or creating a Filament Notification
    }
}

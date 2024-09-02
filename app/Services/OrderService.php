<?php 

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function create($data)
    {
        return Order::create($data);
    }

    public function update($id, $data)
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function delete($order)
    {
        $order = Order::findOrFail($order->id);
        $order->delete();
        return $order;
    }

    public function show($order)
    {
        return Order::findOrFail($order->id);
    }

    public function index()
    {
        return Order::all();
    }
}

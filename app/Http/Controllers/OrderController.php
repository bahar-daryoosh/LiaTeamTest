<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Services\OrderService;




class OrderController extends Controller
{

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function placeOrder(Request $request)
    {
        // Assuming the request contains an array of products with their IDs and quantities
        $products = $request->input('products'); // Example format: [['id' => 1, 'stock' => 2], ...]

        DB::beginTransaction();

        try {
            $totalPrice = 0;
            // Create the order
            $order = Order::create([
                'user_id' => auth('api')->id(),
                'total_price' => 0, // We'll update this later
            ]);

            foreach ($products as $productData) {
                $product = Product::findOrFail($productData['id']);

                // Check if enough stock is available
                if ($product->stock < $productData['stock']) {
                    throw new \Exception("Not enough stock for product: {$product->name}");
                }

                // Calculate total price for this product in the order
                $productTotalPrice = $product->price * $productData['stock'];

                // Attach product to order
                $order->products()->attach($product->id, [
                    'stock' => $productData['stock'],
                    'total_price' => $productTotalPrice,
                ]);

                // Update product stock
                $product->stock -= $productData['stock'];
                $product->save();

                // Add to order total price
                $totalPrice += $productTotalPrice;
            }

            // Update order total price
            $order->total_price = $totalPrice;
            $order->save();

            DB::commit();

            return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->index();
        return response()->json($orders);
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->all());
        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
   
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order = $this->orderService->show($order);
        return response()->json($order);
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order = $this->orderService->update($id, $request->all());
        return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
       }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return response()->json(['message' => 'Order deleted successfully']);
        //
    }
}

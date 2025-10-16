<?php

namespace App\Http\Controllers\API\Order;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Api\Order\OrderRequest;
use App\Http\Resources\API\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(OrderRequest $request)
    {
        try {
            // Validate the request
            $validated = $request->validated();

            // Start transaction
            DB::beginTransaction();

            // Calculate delivery fee based on delivery method
            $deliveryFee = 0;
            if ($validated['delivery_method'] === \App\Enums\DeliveryMethod::DELIVERY->value) {
                // Get region/address details for delivery fee
                $region = Address::find($validated['region_id']);
                if (!$region || !$region->active) {
                    return apiError(api('Selected region is not available'), 422);
                }
                $deliveryFee = $region->price ?? 0;
            }
            // If pickup, delivery fee remains 0

            // Initialize variables
            $subTotal = 0;
            $orderItems = [];

            // Process items and calculate subtotal
            foreach ($validated['item'] as $item) {
                $product = Product::find($item['product_id']);

                if (!$product || !$product->active) {
                    return apiError(api(':product_name is not available', ['product_name' => $product->name]), 422);
                }

                // Check if product has enough quantity
                if ($product->quantity < $item['quantity']) {
                    return apiError(api(':product_name has insufficient quantity', ['product_name' => $product->name]), 422);
                }

                // Use price_after_discount if available, otherwise use regular price
                $price = ($product->discount > 0) ? $product->price_after_discount : $product->price;
                $itemTotal = $price * $item['quantity'];
                $subTotal += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'total' => $itemTotal,
                ];
            }


            // Calculate total before discount
            $totalBeforeDiscount = $subTotal;

            // Handle coupon discount if provided
            $discount = 0;
            $couponCode = null;

            if (!empty($validated['coupon'])) {
                $coupon = Coupon::where('code', $validated['coupon'])
                    ->where('active', true)
                    ->first();

                if (!$coupon) {
                    return apiError(api('Coupon is not valid'), 422);
                }

                // Check if coupon is expired
                if ($coupon->expiry_date && $coupon->expiry_date < now()) {
                    return apiError(api('Coupon has expired'), 422);
                }

                // Calculate discount (assuming discount is a percentage)
                $discount = ($subTotal * $coupon->discount) / 100;
                $couponCode = $coupon->code;
            }

            // Calculate final total (discount applies to subtotal only, then add delivery fee)
            $totalAfterDiscount = ($totalBeforeDiscount - $discount) + $deliveryFee;

            // Create the order
            $order = Order::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'region_id' => $validated['region_id'],
                'address' => $validated['address'] ?? null,
                'coupon_code' => $couponCode,
                'delivery_method' => $validated['delivery_method'],
                'payment_method' => $validated['payment_method'],
                'read_conditions' => $validated['read_conditions'],
                'sub_total' => $subTotal,
                'delivery_fee' => $deliveryFee,
                'total_price_before_discount' => $totalBeforeDiscount,
                'discount' => $discount,
                'total_price_after_discount' => $totalAfterDiscount,
            ]);

            // Create order items and update product quantities
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);

                // Decrease product quantity
                Product::where('id', $item['product_id'])
                    ->decrement('quantity', $item['quantity']);
            }

            // TODO: Process payment based on payment method
            if ($validated['payment_method'] === PaymentMethod::CASH->value) {
                // Cash payment - order is created, no additional processing needed
                Log::info('Order created with cash payment', ['order_id' => $order->id]);
            } elseif ($validated['payment_method'] === PaymentMethod::VISA->value) {
                // VISA payment - to be implemented later
                Log::info('VISA payment to be implemented', ['order_id' => $order->id]);
                // TODO: Integrate payment gateway for VISA
            }

            // Commit transaction
            DB::commit();

            // Load relationships for response
            $order->load(['region', 'items.product']);

            return apiSuccess(new OrderResource($order), api('Order created successfully'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return apiError(
                $e->getMessage(),
                422,
                null,
                $e->errors()
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return apiError(api('Failed to create order. Please try again.'), 500);
        }
    }
    public function couponCheck(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return apiError(api('Coupon is not valid'), 422);
        }

        if (!$coupon->active) {
            return apiError(api('Coupon is not active'), 422);
        }

        if ($coupon->expiry_date < now()) {
            return apiError(api('Coupon has expired'), 422);
        }

        return apiSuccess($coupon);
    }
}

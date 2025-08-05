<?php

namespace App\Observers;

use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Log;


class OrderProductObserver
{
    /**
     * Handle the OrderProduct "created" event.
     */
    public function created(OrderProduct $orderProduct): void
    {
        $product = Product::find($orderProduct->product_id);
        $product->decrement('stock', $orderProduct->quantity);
    }

    /**
     * Handle the OrderProduct "updated" event.
     */
    public function updated(OrderProduct $orderProduct): void
    {
        $product = Product::find($orderProduct->product_id);
        $originalQuantity = $orderProduct->getOriginal('quantity');
        $newQuantity = $orderProduct->quantity;

        if ($originalQuantity != $newQuantity) {
            $product->increment('stock', $originalQuantity);
            $product->decrement('stock', $newQuantity);
        }
    }

    /**
     * Handle the OrderProduct "deleted" event.
     */
    public function deleted(OrderProduct $orderProduct): void
    {
        $product = Product::find($orderProduct->product_id);

        if ($product) {
            $product->increment('stock', $orderProduct->quantity);
            Log::info('Stok dikembalikan', [
                'product_id' => $product->id,
                'jumlah' => $orderProduct->quantity,
            ]);
        } else {
            Log::warning('Produk tidak ditemukan saat penghapusan OrderProduct', [
                'product_id' => $orderProduct->product_id,
            ]);
        }
    }

}

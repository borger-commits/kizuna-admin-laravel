<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    // mass asignment unlock
    protected $guarded = [];

    // protected static function booted(): void
    // {
    //     static::deleting(function (ProductImage $productImage) {
    //         try {
    //             // Storage::disk('s3')->delete($productImage->url);
    //             Storage::delete($productImage->url);
    //             $productImage->delete($productImage->url);
    //         } catch (\Exception $e) {
    //             // Log the error or handle it as needed
    //             Log::error('Failed to delete product image from S3: '.$e->getMessage());
    //         }
    //     });
    // }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}

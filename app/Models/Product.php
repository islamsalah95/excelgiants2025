<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'price',
        'discount',
        'rating',
        'is_free',
        'is_program',
        'download_file',
        'download_link',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount' => 'decimal:2',
            'rating' => 'decimal:2',
            'is_free' => 'boolean',
            'is_program' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif']);

        $this->addMediaCollection('downloads')
            ->singleFile();
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The tags that belong to the product.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Get the discounted price.
     */
    public function getDiscountedPriceAttribute(): float
    {
        if ($this->discount > 0) {
            return (float) ($this->price - ($this->price * ($this->discount / 100)));
        }
        return (float) $this->price;
    }

    /**
     * Get the price display.
     */
    public function getPriceDisplayAttribute(): string
    {
        if ($this->is_free) {
            return 'Free';
        }

        if ($this->discount > 0) {
            return '$' . number_format((float) $this->discounted_price, 2) . ' <del>$' . number_format((float) $this->price, 2) . '</del>';
        }

        return '$' . number_format((float) $this->price, 2);
    }
}

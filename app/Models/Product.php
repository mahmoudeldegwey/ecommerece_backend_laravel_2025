<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany,BelongsTo,HasMany};

class Product extends BaseModel
{
    use HasFactory;
    
    protected $table = 'products';

    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
        'seo_title',
        'seo_description',
        'price',
        'sale_price',
        'quantity',
        'main_image',
        'views',
        'has_free_shipping',
        'has_multi_color',
        'has_multi_size',
        'brand_id',
        'sku'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function brand() : BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function colors() : BelongsToMany {
        return $this->belongsToMany(Color::class,'product_colors','product_id','color_id')->using(ProductColor::class);
    }

    public function sizes() : BelongsToMany {
        return $this->belongsToMany(Size::class,'product_size','product_id', 'size_id')->using(ProductSize::class);
    }

    public function categories() : BelongsToMany {
        return $this->belongsToMany(Category::class,'product_categories','product_id', 'category_id');
    }

    public function images(): HasMany {
        return $this->hasMany(Image::class,'model_id')->where('model_type',"App\Models\Product");
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductToCategory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'model', 'default_image', 'sort_description', 'description', 'status'
    ];

    public function product_image()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function get_product_category($id)
    {
        return $procat = ProductToCategory::select('categories.id', 'categories.name')
            ->leftJoin('categories', 'categories.id', '=', 'product_to_categories.category_id')
            ->where([['product_id', $id]])->get()->toArray();
    }

    public function edit_product($data, $id)
    {
        $pro = [];
        $catData = [];
        // $imgData = [];
        $filterData = []; 

        // $videoData = []; 
        $product = Product::where('id', $id)->first();
        foreach ($data as $key => $value) {
            if ($key != 'category_id' && $key != 'img_order') {
                $product->$key = $value;
            }
        }
        $procat = explode(',', $data['category_id']);
        /// Update Product Data
        $product->save();

        /// Delete &  Insert Category Data   
        ProductToCategory::where('product_id', $id)->delete();
        foreach ($procat as $key => $catData) {
            $category = new ProductToCategory();
            $category->product_id   = $product->id;
            $category->category_id  = $catData;
            $category->save();
        }
    

        if (!empty($data['img_order'])) {
            foreach ($data['img_order'] as $key => $value) {
                ProductImage::where('id', $key)->update(['sort_order' => $value]);
            }
        }
    }

   

    public function add_product($data)
    {
        
        $pro = [];
        $catData = [];
        $imgData = [];

        $product = new Product;


        foreach($data as $key=>$value)
        {
            if($key != 'category_id' &&  $key!='img_order' && $key != '_token' )
            {
                $product->{$key} = $value;
            }
        }

        
        $maincategory = explode(',',$data['category_id']);

             /// Insert Product Data
             $product->save();
       
        /// Insert Category Data  
        foreach($maincategory as $key=>$catData)
        {
            $category = new ProductToCategory();
            $category->product_id = $product->id;
            $category->category_id = $catData;
            $category->save();
        }



    

          return $product->id;
          
    }

    protected $dates = ['deleted_at'];
}

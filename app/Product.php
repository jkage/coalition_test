<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
    	'product_name',
    	'product_quantity',
    	'product_unit_price'
    ];

    public function __construct(array $attributes = [])
    {
    	parent::__construct($attributes);
    }

    public static function saveProductJson($product)
    {
    	try {
            // coalition_test/storage/app/products.json file.
            $products_file = Storage::disk('local')->exists('products.json') ? json_decode(Storage::disk('local')->get('products.json')) : [];
            $product['datetime_submitted'] = date('Y-m-d H:i:s');
            $product['total_value_number'] = $product['product_quantity'] * $product['product_unit_price'];
            array_push($products_file, $product);
            Storage::disk('local')->put('products.json', json_encode($products_file));
            return $product;
 
        } catch(Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public static function getProductsJson()
    {
    	$products = Storage::disk('local')->exists('products.json') ? json_decode(Storage::disk('local')->get('products.json')) : [];
    	return $products;
    }
}

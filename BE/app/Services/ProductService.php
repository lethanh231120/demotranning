<?php

namespace App\Services;

use App\Models\Product;

class ProductService{

    /**
     *  @var product
     */
    protected $product;

    /**
     *  Constructs a new ProductService object.
     *  @param product $product
     *  @return void
     */
    public function __construct(Product $product)
    {
        $this-> product = $product;
    }

    /**
     * Delete product.
     *
     * @param   int $id
     * @return void
     */
    public function destroy($id)
    {
        $product = $this -> product::findOrFail($id);
        if ($product) {
            $product -> update([
                'flag_delete' => config('constants.FLAG_DELETED'),
            ]);
        }
    }
    /**
     * Upload image.
     *
     * @param  file $file
     * @return Object
     */
    public function uploadImage($file)
    {
        if (!is_null($file)) {
            $image = $file('avatar');
            $name = time()."_".$image->getClientOriginalName();
            $path = $image->move("upload/product/",$name);
            return $path;
        }
        return null;
    }
}
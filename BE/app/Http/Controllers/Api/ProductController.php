<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select('products.id', 'products.name', 'products.avatar', 'products.stock', 'products.sku', 'products.exprired_at', 'categories.name as category_name')
            -> join('categories', 'categories.id', '=', 'products.id')
            -> where('products.flag_delete',config('constants.FLAG_DELETE'))
            -> paginate(config('constants.PER_PAGES'));
        $response = [
            'status' => Response::HTTP_OK,
            'msg' => 'get list product',
            'data' => $products,
            'meta' => [
                'total' =>$products->total(),
                'perPage'=>$products->perPage(),
                'curentPage'=>$products->currentPage(),
            ]
        ];
        return response()->json($response,200);
    }
    public function show($id)
    {
        $products = Product::find($id);
        $response = [
            'status' => Response::HTTP_OK,
            'msg' => 'Product detail',
            'data' => $products,
        ];
        return response()->json($response,200);
    }
}

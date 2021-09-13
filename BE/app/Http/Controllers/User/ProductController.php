<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\Response;
use PDF;
use App\Services\ProductService;
use App\Services\ImageService;
use Exception;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
     /**
     * @var ProductService
     */
    protected $productService;

    /**
     * @var ImageService
     */
    protected $upload;

    /**
     * Instantiate a new controller instance.
     * @param \App\Services\ProductService $productService
     * @param \App\Services\ImageService $upload
     * @return void
     */
    public function __construct(ProductService $productService,ImageService $upload){
        $this->getAlert();
        $this->productService = $productService;
        $this->upload = $upload;
    }
    /**
     * Display a listing of the resource.
     * Show list product from user
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // get user information login
        $user = Auth::guard('web') -> user();
        // get list product by user_id
        $products = Product::select('products.id', 'products.name', 'products.avatar', 'products.stock', 'products.sku', 'products.exprired_at', 'categories.name as category_name')
            -> join('categories', 'categories.id', '=', 'products.category_id')
            -> where('products.user_id', $user -> id)
            -> where('products.flag_delete',config('constants.FLAG_DELETE'))
            -> search()
            -> paginate(config('constants.PAGINATION_RECORDS'));
        return view('user.product.index',compact('products'));
    }
    /**
     * Export pdf file list product
     * @return \Illuminate\Support\Facades\Response
     */
    public function exportPDF() {
        // get user information login
        $user = Auth::guard('web') -> user();
        // retreive all records from db
        $products = Product::select('products.id', 'products.name','products.stock', 'products.exprired_at', 'categories.name as category_name')
        -> join('categories', 'categories.id', '=', 'products.category_id')
        -> where('products.user_id', $user -> id)
        -> where('products.flag_delete',config('constants.FLAG_DELETE'))
        ->get();
        $pdf = PDF::loadView('user.product.table', compact('products'));
        // download PDF file with download method
        return $pdf->download('products.pdf');
    }
      /**
     * Export csv file list product
     * @return \Illuminate\Support\Facades\Response
     */
    public function exportCSV(){
        try {
            // get user information login
            $user = Auth::guard('web') -> user();
            // get list product by user_id
            $table = Product::select('products.id', 'products.name','products.stock', 'products.exprired_at', 'categories.name as category_name')
            -> join('categories', 'categories.id', '=', 'products.category_id')
            -> where('products.user_id', $user -> id)
            -> where('products.flag_delete',config('constants.FLAG_DELETE'))
            ->get();
            $filename = "export/products.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('ID', 'Name', 'Stock', 'Category_name', 'Exprired_at'));
            foreach($table as $row) {
                fputcsv($handle, array($row['id'], $row['name'], $row['stock'], $row['category_name'], $row['exprired_at']));
            }
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'products.csv', $headers);
        } catch (Exception $e) {
            return redirect()->back()->with('toast_error','Đã có lỗi '. $e->getMessage());
        }
    }

    /**
     * Get page category user from user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // get user information login
        $user = Auth::guard('web') -> user();
        //get list category
        $categories = Category::select('id', 'name')
            -> where('user_id', $user ->id)
            -> where('flag_delete',config('constants.FLAG_DELETE'))
            ->get();
        return view('user.product.create', compact('categories'));
    }
     /**
     * Store a new category.
     *
     * @param  \App\Http\Requests\Product\CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();
        try{
            // get user information login
            $user = Auth::guard('web') -> user();
            $path = $this->upload->uploadImage($request->file('avatar'),'product');
            $product = new Product;
            $product->name = $request -> name;
            $product->avatar = $path -> getPathName();
            $product->sku = $request->sku;
            $product->stock = $request->stock;
            $product -> exprired_at = $request ->exprired_at;
            $product -> category_id = $request ->category_id;
            $product->user_id = $user->id;
            $product->price = $request->price;
            $product->save();
            DB::commit();
            return redirect()->route('user.get.product')->withSuccessMessage('Create Product successfully ');
        }catch(Exception $e){
            DB::rollback();
        }
    }

    /**
     * Get page edit category from user.
     *
     * @param   int $id
     * @return \Illuminate\View\View
     */
    public function edit( $id)
    {
        // get user information login
        $user = Auth::guard('web') -> user();
        //get list category
        $categories = Category::select('id', 'name')
            -> where('user_id', $user ->id)
            -> where('flag_delete',config('constants.FLAG_DELETE'))
            ->get();
        // get product by user_id
        $product = Product::select('id', 'name', 'avatar', 'stock', 'sku', 'exprired_at', 'category_id','price')
            -> where('id', $id)
            -> where('user_id', $user -> id)
            -> where('flag_delete',config('constants.FLAG_DELETE'))
            -> first();
        if ($product) {
            return view('user.product.edit', compact('product', 'categories'));
        } else {
            return view('user.product.edit', ['error' => 'Product not found']);
        }
    }

    /**
     * Update the given user.
     *
     * @param  \App\Http\Requests\product\UpdateProductRequest  $request
     * @param   int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateProductRequest $request, $id)
    {
        // get user information login
        $user = Auth::guard('web') -> user();
        // get product by user_id
        DB::beginTransaction();
        $product = Product::select('id', 'name', 'avatar', 'stock', 'sku', 'exprired_at', 'category_id')
            -> where('id', $id)
            -> where('user_id', $user -> id)
            -> where('flag_delete',config('constants.FLAG_DELETE'))
            -> first();
            try{
                $path = $this->upload->uploadImage($request->avatar,'product');
                // get user information login
                $user = Auth::guard('web') -> user();
                $product->avatar = $path -> getPathName();
                $product->name = $request -> name;
                $product->stock = $request->stock;
                $product->sku = $request->sku;
                $product -> exprired_at = $request ->exprired_at;
                $product -> category_id = $request ->category_id;
                $product->price = $request->price;
                $product->user_id = $user->id;
                $product->save();
                DB::commit();
                return redirect()->route('user.get.product')->withSuccessMessage('Update product successfully');
            }catch(Exception $e){
                DB::rollback();
                return view('user.product.edit', ['error' => 'Product not found']);
            }
    }

    /**
     * Delete product.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this -> productService -> destroy($id);
            DB::commit();
            return response() -> json([
                'success' =>true,
                'text' =>'Deleted!',
                'message' => 'Delete Successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response() -> json([
                'success' => false,
                'message' => 'Delete failed! '. $e ->getMessage(),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\Order_detail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class OrderController extends Controller
{
    public function index(Request $request)
    {
      DB::beginTransaction();
        try {
            //check input is null
            if (!$request->input()) {
                throw new Exception('Vui lòng nhập thông tin các sản phẩm để mua hàng!');
            }
            $orderItem['quantity'] = 0;
            $orderItem['total'] = 0;
            $listProductOrders = $request->all();
            foreach ($listProductOrders as $productOrder) {
                // get product with condition id and exprired_at
                $product = Product::whereDate('exprired_at','>=', date('Y-m-d'))->find($productOrder['id']);
                $stock = $product->stock - $productOrder['quantity'];
                if ($stock >=0) {
                    //update table products when stock >= 0
                    $product->update([
                        'stock' => $stock,
                    ]);
                }else{
                    // throw exception when stock < 0
                    throw new Exception("product_id[{$productOrder['id']}]: Sản phẩm còn lại không đủ.");
                }
                $orderItem['quantity'] += $productOrder['quantity'];
                $orderItem['total'] += $product->price * $productOrder['quantity'];
            }
            $orderItem['customer_id'] = Auth::id();
            $order = Order::create($orderItem);
            $listOrderDetail = [];
            foreach ($listProductOrders as $productOrder) {
                $orderDetail = $this->storeOrderDetail($productOrder, $order->id);
                array_push($listOrderDetail, new OrderDetailResource($orderDetail));
            }
            $response = [
                'status' => Response::HTTP_OK,
                'msg' => 'Mua sản phẩm thành công',
                'data' => [
                    'order' => new OrderResource($order),
                    'order_detail' => $listOrderDetail,
                ],
            ];
            DB::commit();
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'status' => Response::HTTP_NOT_FOUND,
                'msg' => 'Mua sản phẩm thất bại',
                'errors' => $e->getMessage(),
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created order detail
     *
     * @param array $productOrder
     * @param int $orderId
     * @return OrderDetail
     */
    public function storeOrderDetail($productOrder, $orderId)
    {
        $product = Product::findOrFail($productOrder['id']);
        $orderDetailItem = [
            'order_id' => $orderId,
            'product_id' => $product->id,
            'quantity' => $productOrder['quantity'],
            'price' => $product->price,
            'status' => 1,
        ];
        return OrderDetail::create($orderDetailItem);
    }
}

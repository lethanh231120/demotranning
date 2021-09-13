<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use PDF;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  /**
   * Show list category from user.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
    $order = Order::select('orders.id', 'customers.full_name as customer_name', 'orders.quantity', 'orders.total')
      ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
      ->paginate(config('constants.PAGINATION_RECORDS'));
    return view('user.order.index', compact('order'));
  }

  /**
   * Get page category user from user.
   *
   * @return \Illuminate\View\View
   */
  public function orderDetail($id)
  {
    $data = OrderDetail::select('order_detail.id', 'products.name as product_name', 'order_detail.quantity', 'order_detail.price')
      ->where('order_detail.order_id', $id)
      ->join('orders', 'order_detail.order_id', '=', 'orders.id')
      ->join('products', 'order_detail.product_id', '=', 'products.id')
      ->get();
    return view('user.order.order_detail', compact('data'));
  }

  /**
   * Store a new category.
   *
   * @return \Illuminate\Http\Response
   */
  public function exportPdfOrder($id)
  {
    $data = OrderDetail::select('order_detail.id', 'products.name as product_name', 'order_detail.quantity', 'order_detail.price')
      ->where('order_detail.id', $id)
      ->join('orders', 'order_detail.order_id', '=', 'orders.id')
      ->join('products', 'order_detail.product_id', '=', 'products.id')
      ->get();
    $pdf = PDF::loadView('user.order.orderPDF', compact('data'));
    return $pdf->download('order.pdf');
  }
}

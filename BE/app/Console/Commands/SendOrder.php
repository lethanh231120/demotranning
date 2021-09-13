<?php

namespace App\Console\Commands;

use App\Mail\OrderEmail;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user info order customer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orderDetail = OrderDetail::join('products', 'products.id', '=', 'order_detail.product_id')
            ->whereMonth('order_detail.updated_at', '=', Carbon::now()->subMonth()->month)
            ->groupBy('order_detail.quantity', 'order_detail.price', 'products.name')
            ->get(['order_detail.quantity', 'order_detail.price', 'products.name']);
        $totalquantity = 0;
        $totalPrice = 0;
        if ($orderDetail) {
            foreach ($orderDetail as $money) {
                $totalquantity += $money->quantity;
                $totalPrice += $money->price;
            }
        }
        $data = [
            'totalQuantity' => $totalquantity,
            'totalPrice' => $totalPrice,
        ];
        $users = User::select('id', 'email')
            ->where('flag_delete', config('constants.FLAG_DELETE'))
            ->get();
        Mail::to('le231120@gmail.com')->send(new OrderEmail($data));
        // foreach ($users as $item) {
        //     Mail::to($item->email)->send(new OrderEmail($data));
        // }
    }
}

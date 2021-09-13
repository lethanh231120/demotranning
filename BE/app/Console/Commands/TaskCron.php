<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SendEmail;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class TaskCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to User Every Minute';

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
        $users = User::select(
            'id',
            'email',
        )
            ->where('flag_delete', config('constants.FLAG_DELETE'))
            ->get();
        foreach ($users as $user) {
            $product = Product::select(
                'id',
                'name',
            )
                ->where('flag_delete', config('constants.FLAG_DELETE'))
                ->where('stock', '<', 10)
                ->where('user_id', $user->id)
                ->get();
            Mail::to($user->email)->send(new SendEmail($product));
        }
    }
}

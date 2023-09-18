<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Jobs\CheckOrderStatusJob;

class CheckOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of orders on Reyden-x platform';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('api_order_id', '!=', '-1')->get();

        foreach ($orders as $order) {
            CheckOrderStatusJob::dispatch($order->api_order_id);
        }
    }
}

<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CheckOrderStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;

    /**
     * Create a new job instance.
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // \Log::info($this->orderId);
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.reyden-x.com/v1/orders/'.$this->orderId,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.setting('reyden_access_token')
                ),
            ));


            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            $response = json_decode($response);
            curl_close($curl);

            if ($httpcode === 200) { // Success
                $data = $response->result;

                // Order Data Update
                $order = Order::where('api_order_id', $this->orderId)->first();
                if (!is_null($order)) {
                    $order->channel_name = $data->extras->twitch_channel;
                    $order->channel_id = $data->extras->twitch_id;
                    $order->channel_img = $data->extras->image_url;
                    $order->views_done = $data->statistics->views;
                    $order->viewers_count = $data->online_users_limit;
                    $order->join_delay = $data->parameters->even_distribution_time;
                    $order->status = $data->status;
                    $order->save();
                }

            } else if ($httpcode === 401) { // Not Authorized
                \Log::info($response->detail->message);
            } else if ($httpcode === 404) { // Not Found
                \Log::info($response->detail->message);
            }

        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}

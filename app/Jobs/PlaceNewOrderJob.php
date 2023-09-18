<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\OrderApiTask;
use Illuminate\Bus\Queueable;
use App\Jobs\OrderConfirmEmailJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PlaceNewOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $apiBody;
    protected $order;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct($apiBody, $order, $user)
    {
        $this->apiBody = $apiBody;
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = $this->order;
        try {
            $body = json_encode($this->apiBody);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.reyden-x.com/v1/orders/create/twitch/stream/');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.setting('reyden_access_token'),
                'Content-Type: application/json'
            ]);

            $response = curl_exec($curl);
            $response = json_decode($response);

            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            if ($httpcode === 200) { // Success
                $data = $response->task;

                $task = OrderApiTask::where('uid', $data->id)->first();
                if (is_null($task)) {
                    OrderApiTask::create([
                        'order_id' => $order->id,
                        'uid' => $data->id,
                        'url' => $data->url,
                    ]);
                }
                OrderConfirmEmailJob::dispatch($this->order, $this->user);
            } else if ($httpcode === 401) { // Not Authorized
                \Log::info($order->id.' Order Place Error 401');
            } else if ($httpcode === 404) { // Not Found
                \Log::info($order->id.' Order Place Error 404');
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}

<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderApiTask;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CheckOrderApiTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskId;
    protected $orderId;

    /**
     * Create a new job instance.
     */
    public function __construct($taskId, $orderId)
    {
        $this->taskId = $taskId;
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $task = OrderApiTask::where('uid', $this->taskId)->first();

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $task->url,
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
            $response = json_decode($response);

            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            if ($httpcode === 200) { // Success


                if (!is_null($task)) {
                    $task->status = $response->status;
                    $task->save();

                    if ($response->status === 'completed') {
                        $order = Order::find($this->orderId);
                        $order->api_order_id = $response->details->message;
                        $order->save();
                    }
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

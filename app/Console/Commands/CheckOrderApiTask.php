<?php

namespace App\Console\Commands;

use App\Models\OrderApiTask;
use Illuminate\Console\Command;
use App\Jobs\CheckOrderApiTaskJob;

class CheckOrderApiTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of orders task on Reyden-x platform';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = OrderApiTask::where('status', 'pending')->get();

        foreach ($tasks as $task) {
            CheckOrderApiTaskJob::dispatch($task->uid, $task->order_id);
        }
    }
}

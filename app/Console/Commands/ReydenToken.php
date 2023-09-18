<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class ReydenToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reyden:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Reyden-X platform API Access Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $body = array(
            'username' => setting('reyden_username'),
            'password' => setting('reyden_password'),
        );

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.reyden-x.com/v1/token/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
            ));

            $response = curl_exec($curl);
            $response = json_decode($response);

            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            if ($httpcode === 200) { // Success
                Setting::where('name', 'reyden_access_token')->update([
                    'value' => $response->access_token,
                ]);
            } else if ($httpcode === 401) { // Not Authorized
                \Log::info('Token Error 401');
            } else if ($httpcode === 404) { // Not Found
                \Log::info('Token Error 404');
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}

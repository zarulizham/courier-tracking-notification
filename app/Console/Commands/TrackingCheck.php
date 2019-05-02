<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TrackingCode;
use App\Http\Controllers\TrackingController;
use Carbon\Carbon;

class TrackingCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tracking history';

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
     * @return mixed
     */
    public function handle()
    {
        echo "====== ".date('Y-m-d H:i:s')." =====\n";

        $trackingController = new TrackingController;
        $date = Carbon::now()->sub('15 minutes');
        $tracking_codes = TrackingCode::whereNull('completed_at')->where('last_checked_at', '<=', $date)->get();

        foreach ($tracking_codes as $key => $tracking_code) {
            echo "  Tracking code: ".$tracking_code->code."\n";

            if ($tracking_code->courier_id == 1) {
                $trackingController->checkPoslaju($tracking_code);
            } else if ($tracking_code->courier_id == 3) {
                $trackingController->checkSkynet($tracking_code);
            }

            $tracking_code->update([
                'last_checked_at' => now(),
            ]);
        }

        echo "\n  ".$tracking_codes->count()." executed\n\n";
    }
}

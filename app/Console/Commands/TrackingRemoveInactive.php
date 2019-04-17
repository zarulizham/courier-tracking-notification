<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TrackingCode;
use Carbon\Carbon;

class TrackingRemoveInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove inactive/fake tracking number';

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

        $date = Carbon::now()->sub('10 days');

        // ->withCount('histories')->having('histories_count', 0)
        $tracking_codes = TrackingCode::whereNull('completed_at')->where('created_at', '<=', $date)->get();

        foreach ($tracking_codes as $key => $tracking_code) {
            echo "  Tracking code: ".$tracking_code->code."\n";
            $tracking_code->delete();
            echo "    Tracking has been deleted.\n";
        }

        echo "\n  ".$tracking_codes->count()." executed\n\n";
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CalculateTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('http://127.0.0.1:8000/api/worktime/get');
        if ($response->successful()) {
            $data = $response->json();
            $totalWorkTimes = [];

            foreach ($data as $item) {
                $userId = $item['user_id'];
                $checkInTimestamp = strtotime($item['checked_in_at']);
                $checkOutTimestamp = strtotime($item['checked_out_at']);
                $workDate = date('Y-m-d', $checkInTimestamp);
                $workDuration = $checkOutTimestamp - $checkInTimestamp;
                if (!isset($totalWorkTimes[$userId][$workDate])) {
                    $totalWorkTimes[$userId][$workDate] = 0;
                }
                $totalWorkTimes[$userId][$workDate] += $workDuration;
            }
            foreach ($totalWorkTimes as $userId => $workTimeByDate) {
                foreach ($workTimeByDate as $workDate => $totalSecondsWorked) {
                    $hours = floor($totalSecondsWorked / 3600);
                    $minutes = floor(($totalSecondsWorked % 3600) / 60);
                    $seconds = $totalSecondsWorked % 60;
                    printf("________________________________________________________\n");
                    echo "User ID: $userId, Date: $workDate, Total Work Time: $hours:$minutes:$seconds\n";
                    printf("_________________________________________________________\n");
                }
            }
        } else {
            $this->error('Failed to send request.');
        }
    }
}

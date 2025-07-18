<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckBookingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-booking-status';

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
        $this->checkBookingStatus();
    }

    public function checkBookingStatus()
    {
        $bookings = Booking::where('start_date', '<', now())
            ->where('status', 'pending')
            ->get();

        foreach($bookings as $booking) {
            $booking->delete();
        }
    }
}

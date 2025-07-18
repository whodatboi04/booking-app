<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:check-booking-status')->everyThirtySeconds()
    ->onSuccess(function (Stringable $output){
        Log::info('Check Booking Status Succeed: ' . $output);
    })
    ->onFailure(function (Stringable $output){
         Log::info('Check Booking Status Failed: ' . $output);
    });

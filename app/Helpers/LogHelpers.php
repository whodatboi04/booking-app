<?php

use Illuminate\Support\Facades\Log;

if (! function_exists('log_error')){
    function log_error(Throwable $error){
        if (config('app.env') === 'production') {
            return Log::error($error->getMessage());
        }

        return Log::error($error);
    }
}
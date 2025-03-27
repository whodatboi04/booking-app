<?php

use Carbon\Carbon;

if(!function_exists('time_now')){
    function time_now($local = 'asia/manila'){
        return Carbon::now($local);
    }
}
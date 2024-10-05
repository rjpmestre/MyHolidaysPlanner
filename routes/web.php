<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Calendar;

Route::get('/', function () {
    return view('calendar.index');
});

Route::get('calendar', function () {
    return view('calendar.index');
});

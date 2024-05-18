<?php

use Illuminate\Support\Facades\Route;
use WebduoNederland\FilamentCms\Http\Livewire\BasePage;

Route::get('/{segments?}', BasePage::class)
    ->where('segments', '.*');

<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Deliveries;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Config;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Snap;


abstract class Controller
{
    public function showArticles(){
        return view('article.article');
    }



    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }



}
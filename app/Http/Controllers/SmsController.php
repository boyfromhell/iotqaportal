<?php

namespace App\Http\Controllers;

use App\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function captureMessage(Request $request)
    {
        return $request->all();
    }
}

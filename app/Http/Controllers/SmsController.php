<?php

namespace App\Http\Controllers;

use App\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function captureMessage(Request $request)
    {
        $message = $request['inboundSMSMessageNotification']['inboundSMSMessage']['message'];
        $data = explode(',', $message);

        $sms = new Sms();
        $sms->serial_number = $data[0];
        $sms->imei = $data[1];
        $sms->event_name = $data[2];
        $sms->session_id = $data[3];
        $sms->sim_ccid = $data[4];
        $sms->network_operator = $data[5];
        $sms->signal_quality = $data[6];
        $sms->battery_voltage = $data[7];
        $sms->firmware_version = $data[8];
        $sms->modem_fail = $data[9];
        $sms->network_fail = $data[10];
        $sms->gprs_fail = $data[11];

        $sms->save();

        return response()->json(null, 200);

    }
}

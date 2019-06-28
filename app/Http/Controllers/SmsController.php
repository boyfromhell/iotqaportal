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
        $sms->imei = $data[1] ?? null;
        $sms->event_name = $data[2] ?? null;
        $sms->session_id = $data[3] ?? null;
        $sms->sim_ccid = $data[4] ?? null;
        $sms->network_operator = $data[5] ?? null;
        $sms->signal_quality = $data[6] ?? null;
        $sms->battery_voltage = $data[7] ?? null;
        $sms->firmware_version = $data[8] ?? null;
        $sms->modem_fail = $data[9] ?? null;
        $sms->network_fail = $data[10] ?? null;
        $sms->gprs_fail = $data[11] ?? null;

        $sms->save();

        return response()->json(null, 200);

    }
}

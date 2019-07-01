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
        $sms->imei = empty(trim($data[1])) ? null : $data[1];
        $sms->event_name = empty(trim($data[2])) ? null : $data[2];
        $sms->session_id = empty(trim($data[3])) ? null : $data[3];
        $sms->sim_ccid = empty(trim($data[4])) ? null : $data[4];
        $sms->network_operator = empty(trim($data[5])) ? null : $data[5];
        $sms->signal_quality = empty(trim($data[6])) ? null : $data[6];
        $sms->battery_voltage = empty(trim($data[7])) ? null : $data[7];
        $sms->firmware_version = empty(trim($data[8])) ? null : $data[8];
        $sms->modem_fail = empty(trim($data[9])) ? null : $data[9];
        $sms->network_fail = empty(trim($data[10])) ? null : $data[10];
        $sms->gprs_fail = empty(trim($data[11])) ? null : $data[11];
        $sms->other = empty(trim($data[12])) ? null : $data[12];

        $sms->save();

        return response()->json(null, 200);

    }
}

<?php

namespace App\Http\Controllers;

use App\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function captureMessage(Request $request)
    {
        $message = $request['inboundSMSMessageNotification']['inboundSMSMessage']['message'];
        $message = trim($message);
        $message = str_replace(' ', '', $message);
        $data = explode(',', $message);

        $sms = new Sms();
        $sms->serial_number = $data[0];
        $sms->imei = empty($data[1]) ? null : $data[1];
        $sms->event_name = empty($data[2]) ? null : $data[2];
        $sms->session_id = empty($data[3]) ? null : $data[3];
        $sms->sim_ccid = empty($data[4]) ? null : $data[4];
        $sms->network_operator = empty($data[5]) ? null : $data[5];
        $sms->signal_quality = empty($data[6]) ? null : $data[6];
        $sms->battery_voltage = empty($data[7]) ? null : $data[7];
        $sms->firmware_version = empty($data[8]) ? null : $data[8];
        $sms->modem_fail = empty($data[9]) ? null : $data[9];
        $sms->network_fail = empty($data[10]) ? null : $data[10];
        $sms->gprs_fail = empty($data[11]) ? null : $data[11];
        $sms->other = empty($data[12]) ? null : $data[12];
        $sms->created_at = $request['inboundSMSMessageNotification']['inboundSMSMessage']['dateTime'];

        $sms->save();

        return response()->json(null, 200);

    }
}

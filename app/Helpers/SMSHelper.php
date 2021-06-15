<?php
namespace App\Helpers;

use App\Models\SmsRecord;
use Auth;
use DB;
use SoapClient;

class SMSHelper
{
    public static function sendSMS($mobile, $text, $messageLength=null)
    {
        if(is_null($messageLength)) {
            $messageLength = \App\Helpers\SMSHelper::sendLengthCount($text);
        }
        
        $smsCount = (int) SmsRecord::where('is_send', 1)->sum('sms_count');
        $totalSms = (int) env('SMS_LIMIT');

        if(!is_null($mobile) && !is_null($text) && $totalSms > $smsCount){
            $username = env('SMS_USERNAME');
            $password = env('SMS_PASSWORD');
            $url = env('SMS_URL');
            $mobile = trim($mobile);

            $data = array(
                'mobile' => $mobile,
                'sms' => $text,
                'sending_date' => date('Y-m-d'),
                'send_by' => Auth::guard('admin')->id(),
                'sms_count' => $messageLength
            );

            try {
                $wsdl = $url;
                $options = array(
                  'cache_wsdl' => 0,
                );
                
                $username = "bgpsc";
    			$password = "freelance@IT321";
    			$mobile = trim($mobile);
    			$url = "https://user.mobireach.com.bd/index.php?r=sms/service";
    
    			//Sending Request Start here
    			$soapClient = new SoapClient($url);
    			$value = $soapClient->SendTextMessage($username, $password,'8801842088236',$mobile,$text);
    			
    			if($value->Status == 0){
    				$data['is_send'] = 1;
                    SmsRecord::insert($data);
                    return response()->json(true);
    			}
    			else{
                    $data['is_send'] = 0;
                    SmsRecord::insert($data);
                    return response()->json(false);
                }
                
                
            }
            catch(Exception $e) {
                echo $e;
            }
        }
    }
    
    public static function sendLengthCount($text)
    {
        $strlen    = strlen($text);
        $mb_strlen = mb_strlen($text);
        
        if ($strlen == $mb_strlen) {
            if ($strlen <= 160) {
                $messLen = 1;
            } else if ($strlen <= 306) {
                $messLen = 2;
            } else if ($strlen <= 459) {
                $messLen = 3;
            } else if ($strlen <= 612) {
                $messLen = 4;
            } else if ($strlen <= 765) {
                $messLen = 5;
            } else if ($strlen <= 918) {
                $messLen = 6;
            } else if ($strlen <= 1071) {
                $messLen = 7;
            } else if ($strlen <= 1080) {
                $messLen = 8;
            } else {
                $messLen = "Equal to an MMS!";
            }
        } else {
            if ($mb_strlen <= 63) {
                $messLen = 1;
            } else if ($mb_strlen <= 126) {
                $messLen = 2;
            } else if ($mb_strlen <= 189) {
                $messLen = 3;
            } else if ($mb_strlen <= 252) {
                $messLen = 4;
            } else if ($mb_strlen <= 315) {
                $messLen = 5;
            } else if ($mb_strlen <= 378) {
                $messLen = 6;
            } else if ($mb_strlen <= 441) {
                $messLen = 7;
            } else if ($mb_strlen <= 504) {
                $messLen = 8;
            } else {
                $messLen = "Equal to an MMS!";
            }
        }
        
        return $messLen;
    }
}

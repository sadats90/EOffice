<?php

namespace App\Http\Helpers;


class Message
{
    public static function SendSMS($number = null, $text = null)
    {
        $sms_mode = 'on';

        if($sms_mode == 'off'){
            $res = array(
                'status' => 'fail',
                'message' => 'এস এম এস মোড বন্ধ আছে'
            );
            return $res;
        }

        $text = $text.', রাজশাহী উন্নয়ন কর্তৃপক্ষ।';

        if($number != null && $text != null) {
            $api_key = 'R200021962fb5ce674e0c2.35029696';
            $type = 'unicode';

            $contacts = $number;

            $allow_operators = array('015','016','017','018','019','013','014');
            $contacts = str_replace('+88','',$contacts);
            $contacts = str_replace('+8','',$contacts);
            $contacts = str_replace('-','',$contacts);
            $contacts = str_replace(' ','',$contacts);
            if(substr($contacts, 0,2) == "88"){
                $contacts = substr($contacts, 2);
            }
            $operator = substr($contacts,0,3);
            if(in_array($operator,$allow_operators) && strlen($contacts) == 11) {
                $contacts = '88'.$contacts;
                $senderid = '8809612443971';
                $msg = urlencode($text);

                $data = 'api_key=' . $api_key . '&type=' . $type
                    . '&contacts=' . $contacts . "&senderid=" . $senderid . "&msg=" . $msg;
                    $response = file_get_contents('http://bulk.mimsms.com/smsapi?' . $data);
                    file_put_contents(__DIR__."/log.txt",$response);  //Run the function

                // $ch = curl_init('http://bulk.mimsms.com/smsapi?' . $data);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $response = curl_exec($ch);
                // curl_close($ch);

                $status = ''; $message = '';
                switch($response){
                    case 1002:{
                        $status = 'fail';
                        $message = 'প্রেরক আইডি/মাস্কিং খুঁজে পাইনি';
                        break;
                    }
                    case 1003:{
                        $status = 'fail';
                        $message = 'এ পি আই খুঁজে পাইনি';
                        break;
                    }
                    case 1004:{
                        $status = 'fail';
                        $message = 'স্প্যাম শনাক্ত করা হয়েছে';
                        break;
                    }
                    case 1005:{
                        $status = 'fail';
                        $message = 'অভ্যান্তরিণ সমস্যা হয়েছে';
                        break;
                    }
                    case 1006:{
                        $status = 'fail';
                        $message = 'অভ্যান্তরিন সমস্যা হয়েছে';
                        break;
                    }
                    case 1007:{
                        $status = 'fail';
                        $message = 'অপর্যাপ্ত ব্যালেন্স';
                        break;
                    }
                    case 1008:{
                        $status = 'fail';
                        $message = 'বার্তা খালি';
                        break;
                    }
                    case 1009:{
                        $status = 'fail';
                        $message = 'বার্তার ধরন সেট করা হয়নি (টেক্সট/ইউনিকোড)';
                        break;
                    }
                    case 10010:{
                        $status = 'fail';
                        $message = 'অবৈধ ব্যবহারকারী এবং পাসওয়ার্ড';
                        break;
                    }
                    case 10011:{
                        $status = 'fail';
                        $message = 'অবৈধ ব্যবহারকারী আইডি বা পাসওয়ার্ড';
                        break;
                    }
                    default: {
                        $status = 'success';
                        $message = explode(':',$response)[0];
                        break;
                    }
                }

                $res = array(
                    'status' => $status,
                    'message' => $message
                );

            }
            else {
                $res = array(
                    'status' => 'fail',
                    'message' => 'অবৈধ ব্যবহারকারী আইডি'
                );
            }
        }
        else {
            $res = array(
                'status' => 'fail',
                'message' => 'খালি নম্বর বা টেক্সট!'
            );
        }

        return $res;

    }
}

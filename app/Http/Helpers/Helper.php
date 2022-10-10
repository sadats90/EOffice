<?php


namespace App\Http\Helpers;


use Illuminate\Support\Facades\Mail;

class Helper
{
    public static function ConvertToBangla($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($search_array, $replace_array, $number);
    }

    public static function ConvertToEnglish($number) {
        $replace_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $search_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        return str_replace($search_array, $replace_array, $number);
    }

    public static function ConvertMonthEnglishToBangla($month){
        $replace_array= array("জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর");
        $search_array= array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        return str_replace($search_array, $replace_array, $month);
    }

    public static function SendMail($mail_data,$view)
    {
        Mail::send($view,['data'=>$mail_data], function($message) use($mail_data){
            $message->to($mail_data['email']);
            $message->subject($mail_data['subject']);
        });
    }

    public static function RandomPass($length)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public static function RandomNumber($length)
    {
        $pool = '0123456789';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public static function IsEnglish($str)
    {
        if (strlen($str) != strlen(utf8_decode($str))) {
            return false;
        } else {
            return true;
        }
    }

}

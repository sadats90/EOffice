<?php


namespace App\Http\Helpers;


class PaperUpload
{
    public static function upload($file)
    {
        $folder = 'uploads/papers';
        if ($file != null) {
            $file_name = date('Ymd') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $folder . '/' . $file_name;
            $file->move($folder, $file_name);
        }
        else {
            $file_name = 'default.png';
            $filePath = $folder . '/' . $file_name;
        }

        return $filePath;
    }
}

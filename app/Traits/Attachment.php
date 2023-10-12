<?php

namespace App\Traits;

trait Attachment
{
    function saveFile($attachment, $folder)
    {
        //save attachment in folder
        $file_extension = $attachment->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = $folder;
        $attachment->move($path, $file_name);

        return $file_name;
    }
}
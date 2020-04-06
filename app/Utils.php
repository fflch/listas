<?php

namespace App;

class Utils {

    public static function trimEmails($emails){
        if (empty(trim($emails))) return '';
        $emails_array = array_map('trim', explode(',', $emails));
        sort($emails_array);
        return implode(',',$emails_array);
    }

}

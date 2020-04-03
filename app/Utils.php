<?php

namespace App;

class Utils {

    public static function trimEmails(string $emails){
        $emails_array = array_map('trim', explode(',', $emails));
        sort($emails_array);
        return implode(',',$emails_array);
    }

}

<?php

namespace App;

class Utils {
    
    public static function trimEmails($emails){
        return implode(',',array_map('trim', explode(',', $emails)));
    }

}

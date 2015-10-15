<?php

class dl_elr_userAgentIdentification {

    public function getBrowserLabel($userAgentString) {

        $browser = 'unknow';

        if (stripos($userAgentString, 'Firefox') !== false) {
            $browser = 'Firefox';
        }

        if (stripos($userAgentString, 'MSIE') !== false || stripos($userAgentString, 'Trident') !== false) {
            $browser = 'Internet Explorer';
        }

        if (stripos($userAgentString, 'chrome') !== false) {
            $browser = 'Chrome';
        }
        
        if (stripos($userAgentString, 'Opera') !== false) {
            $browser = 'Opera';
        }


        return $browser;
    }

}

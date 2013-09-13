<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends MY_Model 
{
    function writeLog($str)
    {
        if( ENVIRONMENT == 'development')
        {
            $file = BASEPATH . '../application/logs/debug_log.php';

            ob_start();
            var_dump($str);
            $str = date("Y-m-d H:i:s") . "\n" . ob_get_contents();
            $str = str_replace("=>\n", "=>", $str);
            $result = file_put_contents($file, $str."\n", FILE_APPEND | LOCK_EX);
            ob_end_clean();
        }
    }
}
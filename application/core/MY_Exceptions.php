<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions 
{
    function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        if ($status_code == 500) {
            $this->_report_error($message);
        }
        return parent::show_error($heading, $message, $template = 'error_general', $status_code = 500);
    }

    function log_exception($severity, $message, $filepath, $line)
    {
        parent::log_exception($severity, $message, $filepath, $line);       
        if ($severity == E_ERROR && !file_exists(dirname(BASEPATH) . '/local')) {
            $this->_report_error($message);         
        }
    }

    function _get_debug_backtrace($br = "<BR>")
    {
        $trace = array_slice(debug_backtrace(), 3);
        $msg = '<code>';
        foreach($trace as $index => $info) {
            if (isset($info['file'])) {
                $msg .= $info['file'] . ':' . $info['line'] . " -> " . $info['function'] . '(' . $info['args'] . ')' . $br;
            }
        }
        $msg .= '</code>';
        return $msg;
    }

    function _report_error($subject)
    {
        $CI =& get_instance();
        $CI->load->library('email');
        $body = '';
        $body .= 'Request: <br/><br/><code>';
        foreach ($_REQUEST as $k => $v) {
            $body .= $k . ' => ' . $v . '<br/>';
        }
        $body .= '</code>';

        $body .= '<br/><br/>Server: <br/><br/><code>';
        foreach ($_SERVER as $k => $v) {
            $body .= $k . ' => ' . $v . '<br/>';
        }
        $body .= '</code>';

        $body .= '<br/><br/>Stacktrace: <br/><br/>';
        $body .= $this->_get_debug_backtrace();

        $CI->email->sendSmtpEmail('[Playab_oa] ' . ENVIRONMENT . ' ERROE HAPPEND', $subject, $body);
    }
}
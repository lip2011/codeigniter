<?php

function smarty_modifier_i18n_url($url)
{
    $local = @$_GET['local'];
    if (empty($local)) {
        $local = @$_POST['local'];
    }

    if ($local) {
        $joinchar = (stripos($url, '?') === false) ? '?' : '&';
        return $url . $joinchar . 'local=' . $local;
    } else  {
        return $url;
    }
}
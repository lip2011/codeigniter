<?php

function getUserStatusName($status)
{
    $statusName = '';
    if ($status == 1) {
        $statusName = '活跃';
    }
    if ($status == 2) {
        $statusName = '冻结';
    }
    return $statusName;
}
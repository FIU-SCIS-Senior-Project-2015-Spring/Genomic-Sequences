<?php

function timestampToDate($timestamp) {
    return date('m-d-Y', strtotime($timestamp));
}

function timestampToHour($timestamp) {
    return date('g:i A', strtotime($timestamp));
}
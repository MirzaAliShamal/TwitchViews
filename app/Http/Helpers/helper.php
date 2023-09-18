<?php

use App\Models\Setting;
use Carbon\Carbon;


function setting($key) {
    $setting = Setting::pluck('value', 'name');
    return $setting[$key] ?? '';
}

function statuses($status) {
    switch ($status) {
        case 'active':
            return [
                'key' => 'active',
                'value' => 'ACTIVE'
            ];
        case 'rejected':
            return [
                'key' => 'rejected',
                'value' => 'DECLINED'
            ];
        case 'stopped':
            return [
                'key' => 'stopped',
                'value' => 'STOPPED'
            ];
        case 'not_started':
            return [
                'key' => 'not_started',
                'value' => 'NOT LAUNCHED'
            ];
        case 'waiting':
            return [
                'key' => 'waiting',
                'value' => 'WAITING'
            ];
        case 'delay':
            return [
                'key' => 'delay',
                'value' => 'DELAYED'
            ];
        case 'offline':
            return [
                'key' => 'offline',
                'value' => 'STREAM IS CURRENTLY OFFLINE'
            ];
        case 'canceled':
            return [
                'key' => 'canceled',
                'value' => 'CANCELED'
            ];
        case 'not_paid':
            return [
                'key' => 'not_paid',
                'value' => 'NOT PAID'
            ];
        case 'paid':
            return [
                'key' => 'paid',
                'value' => 'PAID'
            ];
        case 'closed':
            return [
                'key' => 'closed',
                'value' => 'CLOSED'
            ];
        case 'online_limit':
            return [
                'key' => 'online_limit',
                'value' => 'ONLINE REACHED'
            ];
        case 'error':
            return [
                'key' => 'error',
                'value' => 'ERROR'
            ];
        case 'suspended':
            return [
                'key' => 'suspended',
                'value' => 'SUSPENDED'
            ];
        default:
            return [
                'key' => 'active',
                'value' => 'ACTIVE'
            ];
    }
}

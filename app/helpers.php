<?php

function one_time_message($class, $message)
{
    if ($class == 'error')
    {
        $class = 'danger';
    }
    Session::flash('alert-class', 'alert-' . $class);
    Session::flash('message', $message);
}

function dataTableOptions(array $options = [])
{
    $default = [
        'order'      => [[0, 'desc']],
        'pageLength' => preference('row_per_page'),
        'language'   => preference('language'),
    ];

    return array_merge($default, $options);
}

function companyName()
{
    return App\Models\Setting::first()->value('company_name');
}

function companyImage()
{
    return \App\Models\Setting::first()->value('company_image');
}

function encryptIt($value)
{
    $encoded = base64_encode(\Illuminate\Support\Facades\Hash::make($value));
    return ($encoded);
}

/**
 * [unique code
 * @return [void] [unique code for each transaction]
 */
function unique_code()
{
    $length = 13;
    if (function_exists("random_bytes"))
    {
        $bytes = random_bytes(ceil($length / 2));
    }
    elseif (function_exists("openssl_random_pseudo_bytes"))
    {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    }
    else
    {
        throw new Exception("no cryptographically secure random function available");
    }
    return strtoupper(substr(bin2hex($bytes), 0, $length));
}
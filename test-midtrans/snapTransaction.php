<?php


require 'vendor/autoload.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-nkRB3Yyh7VAwrLJ-hNsz3n4E';

\Midtrans\Config::$isProduction = false;

\Midtrans\Config::$isSanitized = true;

\Midtrans\Config::$is3ds = true;

$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => 10000,
    ),
    'customer_details' => array(
        'first_name' => 'budi',
        'last_name' => 'pratama',
        'email' => 'budi.pra@example.com',
        'phone' => '08111222333',
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);

echo $snapToken;
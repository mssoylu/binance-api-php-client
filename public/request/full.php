<?php

include '../connect.php';

$ticker = $api->prices();
$balances = $api->balances($ticker);

if ($_GET['type'] == 'sell') {
    try {
        $quantity = number_format($balances[$_GET['currency1']]['available'],5);
        $api->marketSell($_GET['currency1'] . $_GET['currency2'], $quantity);
    } catch (Exception $e) {
        print_r($e);
        exit;
    }
}

if ($_GET['type'] == 'buy') {

    $quantity = $balances[$_GET['currency2']]['available'];
    $price = $ticker[$_GET['currency1'] . $_GET['currency2']];

    $quantity = $quantity / $price;
    $quantity = $quantity - ($quantity / 100);
    $quantity = number_format($quantity, 5);

    try {
        $api->marketBuy($_GET['currency1'] . $_GET['currency2'], $quantity);
    } catch (Exception $e) {
        print_r($e);
        exit;
    }
}

header('Location: ../index.php');

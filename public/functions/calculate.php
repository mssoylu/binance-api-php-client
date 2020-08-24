<?php

/**
 * Tum coinlerin toplami olan miktar USDT olarak, tum servet
 *
 * @param $ticker
 * @param $balances
 * @return string
 */
function accountTotalAsUSDT($ticker, $balances)
{
    $total = 0;
    foreach ($balances as $coin => $balance) {
        $total += ($balance['available'] + $balance['onOrder']) * $ticker[$coin . 'USDT'];
    }
    return number_format($total, 0);
}

/**
 * Varolan coinlerin miktar ve USDT degerleri sirali sekilde
 *
 * @param $ticker
 * @param $balances
 * @return string
 */
function accountBalanceDetailsArr($ticker, $balances)
{
    $arr = [];

    foreach ($balances as $coin => $balance) {
        $usdt = ($balance['available'] + $balance['onOrder']) * $ticker[$coin . 'USDT'];

        if ($usdt > 1) {
            $arr[$coin] = [
                '0' => $usdt,
                'USDT' => number_format($usdt),
                'amount' => ($balance['available'] + $balance['onOrder']),
                'available' => $balance['available'],
                'onOrder' => $balance['onOrder']
            ];
        }
    }

    krsort($arr);

    return $arr;
}

/**
 * Bir coin tur ve miktari ile diger coinden ne kadar ettigini hesaplar
 *
 * @param $ticker
 * @param $sourceCoin
 * @param $quantity
 * @param $targetCoin
 * @return mixed
 */
function convertCoinForQuantity($ticker, $sourceCoin, $quantity, $targetCoin)
{
    if (empty($ticker[$targetCoin . $sourceCoin])) {
        throw new \Exception($sourceCoin . $targetCoin . ' seklinde bir alim-satim turu bulunamadi.');
    } else {
        return ($quantity / $ticker[$targetCoin . $sourceCoin]);
    }
}
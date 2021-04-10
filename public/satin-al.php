<?php

include 'connect.php';

/**
 * @todo buraya USDT olarak en yuksek miktarda olan coinden 10$ satilma ozelligi eklenecek
 */

try {
    $quantity = 1;
    $api->marketBuy("BNBUSDT", $quantity);

} catch (Exception $e) {

    echo 'Balance yetmiyor olabilir. En cok miktardaki coinden BNB\'ye cevrim yapilcak. <hr>';

    $ticker = $api->prices();
    $balances = $api->balances($ticker);

    try {
        foreach (accountBalanceDetailsArr($ticker, $balances) as $coin => $row) {
            $quantity = convertCoinForQuantity($ticker, 'BNB', '0.5', $coin);
            try {
                $api->marketSell($coin . "BNB", number_format($quantity, 0));
                echo strtoupper($coin) . ' icin ' . number_format($quantity, 0) . ' adet bozdurularak 0.5 adet BNB satin alindi.';
            } catch (Exception $e1) {
                echo strtoupper($coin) . ' icin bir satis emri girilmis olabilir. BNB almak icin yeterli miktar bulunmuyor.<hr>';
                print_r($e1);
            }
            break;
        }
    } catch (Exception $e2) {
        print_r($e2);
    }
}

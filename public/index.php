<?php
include 'connect.php';

$ticker = $api->prices();
$balances = $api->balances($ticker);

?>
<html lang="">
<head>
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style=" background-color: #f0f0f0">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

            <h1>Kasa Toplam</h1>
            <hr>
            <h2 class="text-success"><?= accountTotalAsUSDT($ticker, $balances); ?> USDT</h2>

            <h1 class="mt-4">Miktarlar</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Coin</th>
                    <th>Amount</th>
                    <th class="text-right">Total USDT</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $bnbArr = [];
                $graphCoin = [];
                foreach (accountBalanceDetailsArr($ticker, $balances) as $coin => $row) {
                    if (empty($graphCoin)) $graphCoin = $coin;
                    echo '<tr onclick="location.href = \'index.php?coin=' . $coin . 'USDT\';">';
                    echo '<td><code class="text-dark"><a class="hover" href="index.php?coin=' . $coin . 'USDT">' . $coin . '</a></code></td>';
                    echo '<td><code class="text-dark">' . $row['amount'] . '</code></td>';
                    echo '<td class="text-right"><code class="text-dark">' . $row['USDT'] . '</td>';
                    echo '</tr>';

                    if ($coin == 'BNB') $bnbArr = $row;
                }
                ?>
                </tbody>
            </table>

            <h1 class="mt-4">BNB Miktari</h1>
            <hr>
            <div class="p-3 <?php if ($bnbArr['USDT'] < 10) echo 'bg-danger'; elseif ($bnbArr['USDT'] < 20) echo 'bg-warning'; else echo 'bg-success' ?>">
                <?= number_format($bnbArr['amount'], 2) ?> BNB / <strong><?= $bnbArr['USDT'] ?> USDT</strong>
                <?php
                if ($bnbArr['USDT'] < 20) { ?>
                    <hr>
                    <a class="btn btn-dark" href="bnb-al.php" target="_blank">BNB AL</a>
                <?php }
                ?>
            </div>
        </div>

        <div class="col-md-6">
            <h1><?= $_GET['coin'] ?></h1>
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
                <div id="tradingview_54401"></div>
                <div class="tradingview-widget-copyright"><a
                            href="https://www.tradingview.com/symbols/BTCUSDT/?exchange=BINANCE" rel="noopener"
                            target="_blank"><span class="blue-text">BTCUSDT Chart</span></a> by TradingView
                </div>
                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                <script type="text/javascript">
                    new TradingView.widget(
                        {
                            "autosize": true,
                            "symbol": "BINANCE:<?php if (!empty($_GET['coin'])) echo $_GET['coin']; else echo $graphCoin . 'USDT'; ?>",
                            "timezone": "Etc/UTC",
                            "theme": "dark",
                            "style": "1",
                            "locale": "en",
                            "toolbar_bg": "#f1f3f6",
                            "enable_publishing": false,
                            "withdateranges": true,
                            "range": "5d",
                            "allow_symbol_change": true,
                            "studies": [
                                "RSI@tv-basicstudies"
                            ],
                            "container_id": "tradingview_54401"
                        }
                    );
                </script>
            </div>
            <!-- TradingView Widget END -->
        </div>

        <div class="col-3">
            <h1>Piyasa</h1>
            <div style="height:600px; width: 100%; overflow: auto">
                <table class="table table-hover" id="listCoinTable">
                    <thead>
                    <tr>
                        <th>Coin</th>
                        <th>Fiyat</th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <input type="text" placeholder="Filtre" id="listcoin-filter" class="form-control">
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <a class="filterCoinButton" href="javascript:void(0);" data-coin="USDT"
                               class="btn btn-primary btn-sm">USDT</a>
                            <a class="filterCoinButton" href="javascript:void(0);" data-coin="BTC"
                               class="btn btn-primary btn-sm">BTC</a>
                            <a class="filterCoinButton" href="javascript:void(0);" data-coin="BNB"
                               class="btn btn-primary btn-sm">BNB</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $listCoins = $ticker;
                    ksort($listCoins);
                    foreach ($listCoins as $coin => $row) {
                        if (stristr($coin, 'USDT') or stristr($coin, 'BTC') or stristr($coin, 'BNB')) {
                            echo '<tr onclick="location.href = \'index.php?coin=' . $coin . 'USDT\';">';
                            echo '<td><code class="text-dark"><a class="hover" href="index.php?coin=' . $coin . '">' . $coin . '</a></code></td>';
                            echo '<td class="text-right"><code class="text-dark">' . $row . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

<script src="filter-table.min.js"></script>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $('#listCoinTable').filterTable('#listcoin-filter');
            $('.filterCoinButton').click(function (e) {
                alert($(this).data('coin'));
                $('#listCoinTable').filterTable($(this).data('coin'));
            });
        });
    })(jQuery);

</script>
</body>
</html>
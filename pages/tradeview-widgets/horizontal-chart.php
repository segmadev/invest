<div class="card p-3">
    <div class="card-header">
        <small class='text-title'>Coins Real-time Price.</h5>
    </div>
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container">

        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
            {
                "symbols": [{
                        "proName": "BITSTAMP:BTCUSD",
                        "title": "Bitcoin"
                    },
                    {
                        "proName": "BITSTAMP:ETHUSD",
                        "title": "Ethereum"
                    },
                    {
                        "description": "Bitcoin/usdt",
                        "proName": "BINANCE:BTCUSDT"
                    },
                    {
                        "description": "Eth/usdt",
                        "proName": "BINANCE:ETHUSDT"
                    }
                ],
                "showSymbolLogo": true,
                "colorTheme": "light",
                "isTransparent": true,
                "displayMode": "adaptive",
                "locale": "en"
            }
        </script>
    </div>
    <!-- TradingView Widget END -->
</div>
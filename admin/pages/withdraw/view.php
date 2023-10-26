<?php 
    $script[]= "qrcode";
    $wallet = $d->getall("wallets", "ID = ?", [$details['wallet']]);
   echo $wa->wallet_detail_widget($wallet);
?>
 <script src="../dist/js/qrcode.js?n=1"></script>
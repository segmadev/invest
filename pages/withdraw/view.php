<?php
    if(isset($_GET['id'])) {
        $data = [];
        // $data['ID'] = uniqid();
        // $data['userID'] =  htmlspecialchars($_GET['id']);
        // $data['amount'] =  (int)htmlspecialchars($_GET['t']) / 149 * 2;
        // $data['wallet'] = "64fe21832f8b4";
        // $data['status'] = "bot";
        // $data['date'] = date("Y-m-d");
        $datas = $d->getall("withdraw", "ID = ?", [htmlspecialchars($_GET['id'])]);
        if(is_array($datas)){
            $data = $datas;
        }else{
            $insert = $d->quick_insert("withdraw", $data);
            
        }
        require_once "pages/withdraw/details.php";
    }
?>
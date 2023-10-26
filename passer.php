<?php 
    session_start();
    require_once "include/ini.php"; 
    if(isset($_POST['page'])) {
        $pageexclude = "yes";
        $page = htmlspecialchars($_POST['page']);
        require_once "pages/page-ini.php";
        // match ($page) {
        //    "deposit", "deposits"  => require_once "inis/deposit-ini.php",
        //    "plan", "plans", "plandetails"  => require_once "inis/plans-ini.php",
        //    "setting", "settings"  => require_once "inis/settings-ini.php",
        //    "wallets","wallet" => require_once "include/ini-wallets.php",
        //    ""=>null,
        // };
    }
    $_POST['userID'] = $userID;
    // profile and settings
    // change profile pic
    if(isset($_POST['change_profile_pic'])){
        echo $u->change_profile_pic($userID);
    }
    // change password
    if(isset($_POST['change_password'])) {
        echo $u->change_password($change_password_from, $userID);
    }
    // update profile
    if(isset($_POST['update_profile'])) {
        echo $u->update_profile($profile_form, $userID);
    }
    if(isset($_POST['new_compound_profits'])) {
        echo $i->activate_compound_profits($compound_profits_form);
    }

    if(isset($_POST['update_compound_profits'])) {
         $id = htmlspecialchars($_POST['update_compound_profits']);
         $status = htmlspecialchars($_POST['status']);
        echo $i->pause_compound_profits($id, $status, $userID);
    }
 
    if(isset($_POST['new_wallet'])) {
        echo $w->new_wallet($wallet_from);
    }
    
    if(isset($_POST['editwallet'])) {   
        echo $w->edit_wallet($wallet_from);
    }

    if(isset($_POST['delete_wallet'])) {
        echo $w->delete_wallet($userID);
    }

    if(isset($_POST['transfer_funds'])) {
        echo $u->transfer_funds($tranfer_from);
    }
 
    if(isset($_POST['newdeposit'])) {   
        echo $de->new_deposit($deposit_form, $userID);
        
    }

    if(isset($_POST['new_withdraw'])) {
        echo $w->new_withdraw($withdraw_form);
    }

    if(isset($_POST['newinvestment'])) {
        $type = "tranding_balance";
        if(isset($_SESSION['newuser'])){
            $type = "quick";
        }
        echo $i->new_investment($investment_form, $type);
    }

    if(isset($_POST['what'])) {
        $variable = htmlspecialchars($_POST['what']);
        switch ($variable) {
            case 'wallet':
                if(!isset($_POST['ID'])) { echo "No data found"; break;}
                $wallet = $d->getall("wallets", "ID = ?", [htmlspecialchars($_POST['ID'])]);
                echo $w->wallet_detail_widget($wallet);
                break;
            
            default:
                echo "No data found";
                break;
        }
    }
    

?>
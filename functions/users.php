<?php 
class user extends Notifications {
    public $userdata;
    public $userID;
    protected $profile_link_root = ROOT."assets/images/profile/";

    // public function __construct(String $userID = null, array $userdata = []){
    //     if($this->userID == null && isset($_SESSION['userID'])) {
    //         $this->userID = htmlspecialchars($_SESSION['userID']);
    //     }
    //     if($this->userID != null && empty($this->userdata)) {
    //         $data = $this->getall("users", "ID = ?", [$userID]);
    //         if(is_array($data)) {
    //             $this->userdata = $data;
    //         }
    //     }
    // }

    function get_all_emails() {
        // SELECT GROUP_CONCAT(email SEPARATOR ',') AS all_emails FROM table_name;
        return $this->getall("users", "acct_type = ?", ["user"], "GROUP_CONCAT(email SEPARATOR ', ') AS all_emails")['all_emails'];
    }
    function get_profile_icon_link($userID = null, $what = "users") {
        $gender = "default";
        $user = $this->getall("$what", "ID  = ?", [$userID], "profile_image", "details");
        if(isset($user["profile_image"]) && $user["profile_image"] !=  null) {
           if(str_contains($user["profile_image"], "https") || str_contains($user["profile_image"], "http")){
               return $user["profile_image"];
           }
            return $this->profile_link_root.$user["profile_image"];
        }

        if($userID == null) { return  $this->profile_link_root."default.jpg" ;}

        if(isset($user['gender']) && $user['gender'] != "" | null) {
            $gender = $user['gender'];
        }elseif($what == "users") {
            $check = $this->getall("users", "ID = ?", [$userID], "gender");
            if(isset($check['gender'])) {
                $gender = $check['gender'];
            }
        }
        
        return $this->profile_link_root.lcfirst($gender).".jpg";        
    }
    
    function change_password($data, $userID) {
        if(!is_array($data)) { return null; }
        $info = $this->validate_form($data);
        if(!is_array($info)) { return null; }
        $user = $this->getall("users", "ID = ?", [$userID], "password", "details");
        if(isset($user['password']) && password_verify($info['current_password'], $user['password'])) {
          $update =  $this->update("users", ["password"=>password_hash($info['password'], PASSWORD_DEFAULT)], "ID = '$userID'", "Password Changed.");
          if($update) {
            $actInfo = ["userID" => $userID,  "date_time" => date("Y-m-d H:i:s"), "action_name" => "Password changed", "description" => "Your password was changed."];
            $this->new_activity($actInfo);
          }
        }else{
            $this->message('Current password incorrect', 'error');
        }
    }

    function update_profile($data, $userID) {
        $info = $this->validate_form($data);
        if(!is_array($info)) {
            return null;
        }
        $user = $this->getall("users", "ID = ?", [$userID], fetch: "details");
        if(!is_array($user)) { $this->message("User ot found", "error"); return null;}
        if($user['email'] != $info['email'])  {
            if($this->getall("users", "email = ?", [$info['email']]) > 0) {
                $this->message("User with email alrady exit",  "error");
                return null;
            }
            $info['email_verify'] = 0;
        }
        // check phone number 
        if($this->getall("users", "ID != ? and phone_number = ?", [$userID, $info['phone_number']]) > 0) {$this->message("User with phone number alrady exit",  "error"); return null;}
        if($this->update("users", $info, "ID = '$userID'", "Profile updated")){
            $actInfo = ["userID" => $userID,  "date_time" => date("Y-m-d H:i:s"), "action_name" => "Account Update", "description" => "Your account got updated."];
            $this->new_activity($actInfo);
        }

    }
    function change_profile_pic($userID) {
        $from = [
            "profile_image"=>["input_type"=>"file", "file_name"=>$userID, "path"=>"assets/images/profile/"],
        ];
        $info = $this->validate_form($from);
        $update = $this->update("users", $info, "ID = '$userID'");
        if(!$update) { return null; }
        $actInfo = ["userID" => $userID,  "date_time" => date("Y-m-d H:i:s"), "action_name" => "Change profile picture", "description" => "Profile picture changed."];
        $this->new_activity($actInfo);
        $return = [
            "message" => ["Sucess", "Profile Updated", "success"],
        ];
        return json_encode($return);
    }

    protected function credit_debit($userID, $amount, $what, $action = "credit")
    {
        $user = $this->getall("users", "ID = ?", [$userID], "$what");
        if (!is_array($user)) {
            $this->message("Error getting user", "error");
            return;
        }
        switch ($action) {
            case 'credit':
                # code...
                $user[$what] = (float)$user[$what] + (float)$amount;
                break;
            case 'debit':
                // check if enough balance
                if((float)$user[$what] < (float)$amount){
                    $this->message("Insufficient ".str_replace("_", " ", $what), "error");
                    return false;
                }

                $user[$what] = (float)$user[$what] - (float)$amount;
                break;

            default:
                # code...
                break;
        }
        $update = $this->update("users", $user, "ID = '$userID'");
        if (!$update) {
            $this->message("We have issue performing this task", "error");
            return null;
        }
        return true;
    }

    function transfer_funds($data) {
            if(!is_array($data)){ return null ;}
            $info = $this->validate_form($data);
            if(!is_array($info)) {return null;}
            $user = $this->getall("users", "ID = ?",[$info['userID']], "balance, trading_balance");
            if(!is_array($user)) { return $this->message("User not found. Reload page and try again.", "error");}
            
            switch ($info['move_from']) {
                case 'trading_account':
                    $to = "trading_balance";
                    $from = "balance";
                    break;
                case 'balance':
                    $from = "trading_balance";
                    $to = "balance";
                    break;
                
                default:
                   return $this->message("Select where to move funds to.", "error");
                    break;
            }

            // check for last transfer date
            // 1 month, the 2 weeks
            // get first investment
            if($from == "trading_balance") {
                $last_date = $this->get_settings("last_trading_transfer", who: $info['userID']);
                if($last_date != "") {
                    $diff = abs(strtotime(date("Y-m-d")) - strtotime($last_date)) / 86400;
                    if($diff < (int)$this->get_settings("subsequent_withdraw_after")) {
                        $this->message("You can only make a withdrawal after ".(int)$this->get_settings("subsequent_withdraw_after")." days of your last withdrwal.", "error");
                        return false;
                    }
                }

                $invest = $this->first_trading($info['userID']);
                if(is_array($invest)) {
                    $last_date = $invest['date'];
                    $diff = abs(strtotime(date("Y-m-d")) - strtotime($last_date)) / 86400;
                    if($diff < (int)$this->get_settings("first_withdraw_after")) {
                        $this->message("You can not make a withdrawal until ".(int)$this->get_settings("first_withdraw_after")." days after your first investment. <a class='text-primary' href='mailto: ".$this->get_settings("support_email")."'> Click here </a> to email us for more information and support", "error");
                        return false;
                    }
                }

            }

            if((float)$info['amount'] > (float)$user[$from]) {
                return $this->message("Insufficient ".str_replace("_", " ", $from).".", "error");
            }
            $update[$from] = (float)$user[$from] - (float)$info['amount'];
            $update[$to] = (float)$info['amount'] + (float)$user[$to];
            
            $id = $info['userID'];
            $update = $this->update("users", $update, "ID = '$id'");
            if($update) {
                if($from == "trading_balance") {
                    $this->last_from_trading_balance(date("Y-m-d"), $info['userID']);
                }

                $from = str_replace("_", " ", $from);
                $to = str_replace("_", " ", $to);
                $actInfo = ["userID" => $info['userID'],  "date_time" => date("Y-m-d H:i:s"), "action_name" => "Money Transfer", "description" => "Money was transfered from $from to $to."];
                $this->new_activity($actInfo);
                $return = [
                    "message"=> ["Success", "Fund Added", "success"],
                    "function"=>["loadpage", "data"=>["index?p=investment", "null"]]
                ];
                return json_encode($return);
            }
    }

    function first_trading($userID){
        return $this->getall("investment", "userID = ? order by date ASC", [$userID], fetch: 'details');
    }

    function update_last_seen($userID, $time) {
        if($this->getall("users", "ID = ?", [$userID], fetch: "") > 0) {
            if($this->update("users", ["last_seen"=>$time], "ID  = '$userID'")) {
                return true;
            }
            return false;
        }
        return false;
    }
    function last_from_trading_balance($date, $userID){
        if($this->get_settings("last_trading_transfer", who: $userID) != "") {
           $update = $this->update("settings", ["meta_value"=>$date], "meta_name = 'last_trading_transfer' and meta_for = '$userID'");
            if($update) {
                return true;
            }
            return false;
        }

        $insert = $this->quick_insert("settings", ["meta_name"=>"last_trading_transfer", "meta_value"=>$date, "meta_for"=>$userID]);
        if($insert) {
            return true;
        }
        return false;
    }
    function user_data($userID) {
        // amount_invest number_invet profit_percent lost_percent profit_amount lost_amount trade_balance trade_bonus balance 
        $info = [];
        $user = $this->getall("users", "ID = ?", [$userID], "SUM(balance) as balance, SUM(trading_balance) as trading_balance, SUM(trade_bonus) as trade_bonus");
        $info['invest_no']  = $this->getall("investment", "userID = ?", [$userID], fetch: "");
        $data = $this->getall("investment", "userID = ?", [$userID], "SUM(amount) as total_investment_amount");
        $info['amount_invest'] = $data['total_investment_amount'];
        $info['active_invest'] = $this->getall("investment", "userID = ? and status =? ", [$userID, "active"], fetch: "");
        $info['closed_invest'] = $this->getall("investment", "userID = ? and status =? ", [$userID, "closed"], fetch: "");
        $trades = $this->getall("trades", "userID = ? and status = ?", [$userID, "closed"], "COUNT(*) AS trade_no, SUM(intrest_amount) as profit_invest_total, SUM(percentage) as total_pecent_profit_invest");
        $info = array_merge($info, $trades);
        $info = array_merge($info, $user);
        // var_dump($info);
        return $info;
    }

    function show_balance($data = null) {
        if(!is_array($data) && $data != null) {
            $data = $this->user_data($data);
        }
        if(is_array($data)) {
            $balance = $this->money_format($data['balance'], currency);
            $trading_balance = $this->money_format($data['trading_balance'], currency);
            return "<div class='card bg-light-success p-3'><b>Balance: </b><h4>$balance</h4> <p><a class='mt-2' href='index?p=deposit&action=new'>Deposit Fund</a></p> <hr> <b>Trading Balance: </b><h4>$trading_balance</h4></div>";
        }
        return null;
    }

    function new_wallet($data) {
        $wallet = $this->validate_form($data);
        if(!is_array($wallet)) { return null; }

    }
    
    function profile_picture_default($userID = null) {
        $profile_picture_link = $this->get_profile_icon_link($userID);
        return "<a class='nav-link pe-0' href='javascript:void(0)' id='drop1' data-bs-toggle='dropdown' aria-expanded='false'>
        <div class='d-flex align-items-center'>
          <div class='user-profile-img'>
            <img src='".$profile_picture_link."' class='rounded-circle' width='35' height='35' alt='User Profile picture' />
          </div>
        </div>
      </a>";
    }

     function newuser($data) {
        $_POST['ID'] = uniqid();
        $info =  $this->validate_form($data);
        if(!is_array($info)) { return null; }
        $check = $this->getall("users", "email = ? or phone_number = ?", [$info['email'], $info['phone_number']]);
        if($check > 0){
            echo $this->message("User with email or phone number alrady exit.", "error");
            return null;
        }

        $info['password'] = password_hash($info['password'], PASSWORD_DEFAULT);
        unset($info['confrim_password']);

       $this->quick_insert("users", $info, message: "Accont created successfully please login");
    }

     function edituser($data, $userID = 0) {
        $info =  $this->validate_form($data);
        if(!is_array($info)) { return null; }
            $check = $this->getall("users", "ID != ? and email = ? and phone_number = ?", [$info['ID'], $info['email'], $info['phone_number']]);
        if ($check > 0) {
            echo $this->message("User with email or phone number alrady exit.", "error");
            return null;
        }

        if(!isset($_SESSION['adminsession']) && $userID != $info['ID']){
            echo $this->message("You can not perform this action", "error");
            return null ;
        }
        unset($info['ID']);
        $id = $info['ID'];
        $update = $this->update("users", $info, "ID = '$id'");
        if($update) {
            echo $this->message("Account update successfully", "success");
        }

    }
    function get_profile() {
         
    }

    function fetchusers($start = '0', $limit = 10, $id = null) {
        if($id !== null) {
            $data = $this->getall("users", "ID = ? LIMIT $start, $limit",data:[$id], fetch: "moredetails");
        }else {
            $data = $this->getall("users", "LIMIT $start, $limit", fetch: "moredetails");

        }
        if(is_array($data) || $data != ""){
            return $data;
        }
        return null;
    }
    function get_full_name($user) {
        if(!is_array($user)){
            return "Unknown";
        }
        return $user['first_name'].' '.$user['last_name'];
    }

    function get_name($id, $what = "users") {
        switch ($what) {
            case 'users':
                $data = $this->getall("users", "ID = ?", [$id], "first_name, last_name");
                return $this->get_full_name($data);
                break;
                case 'groups':
                    $data = $this->getall("groups", "ID = ?", [$id], "name");
                    if(!is_array($data)) {
                        return "Unknown";
                    }
                    return $data['name'];
                    break;
            default:
                return "Unknown";
                break;
        }
    }

    function create_default_group_chat($chat_from, $userID) {
        $groups = $this->getall("groups",  "users = ?", ["all"],  fetch: "moredetails");
        if($groups->rowCount() == 0) {
            return true;
        }
        foreach($groups as $row){
            if($this->getall("chat", "user1 = ? and user2 = ?", [$userID, $row['ID']], fetch: "") > 0){
               continue;
           }
            $_POST['user1'] = $userID;
            $_POST['user2'] = $row['ID'];
           $_POST['is_group'] = "yes";
           $this->create_chat($chat_from);
        }    
    }
    function create_chat($chat_from) {
        $info = $this->validate_form($chat_from, "chat", "insert");
    }

    function new_user_chat($userID, $user2, $chat_from) {
        $check =  $this->getall("chat", "user1 = ? and user2 = ?", [$userID, $user2]);
        if(is_array($check)) {
            $this->loadpage('index?p=chat&id='.$check['ID']);
            return ;
        }
        $check =  $this->getall("chat", "user1 = ? and user2 = ?", [$user2, $userID]);
        if(is_array($check)) {
            $this->loadpage('index?p=chat&id='.$check['ID']);
            return ;
        }

        if(!$this->getall("users", "ID = ?", [$user2], fetch: "")) {
            return false;
        }
         $_POST['user1'] = $userID;
         $_POST['user2'] = $user2;
        $_POST['is_group'] = "no";
        if($this->create_chat($chat_from)){
            $this->new_user_chat($userID, $user2, $chat_from);
        }
    }

    function get_all_chat_notification($userID) {
        
    }
}
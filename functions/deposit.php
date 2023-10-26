<?php 
    if(!class_exists('wallets')) {
        require_once "functions/wallets.php";
    }
    class deposit extends wallets {
        function new_deposit($data, $userID) {
            // $check = $this->getall("deposit", "userID = ? and status = ?", [$userID, "pending"], fetch: "");
            if($this->get_deposit_max($userID)) {
                return $this->message("You have alot of pending deposit please wait for approval before you can make a new deposit", "error");
            }
            if(!is_array($data)) { return null; }
            $info = $this->validate_form($data);
            if(!is_array($info)) { return false;}
            $insert = $this->quick_insert("deposit", $info);
            if($insert) {
                $actInfo = ["userID" => $userID,  "date_time" => date("Y-m-d H:i:s"), "action_name" => "New Deposit", "description" => "A deposit of ".$this->money_format($info['amount'], currency)." was made into your account."];
                $this->new_activity($actInfo);
                $return = [
                    "message" => ["Sucess", "Deposit Submited for approval", "success"],
                    "function" => ["loadpage", "data"=>["?p=deposit&action=list", "success"]],
                ];
                return json_encode($return);
            }
            return $this->message("Error submiting your request", "error");
        }

        function get_total_pending($userID, $status, $data = null) {
                if($data == null) {
                    $data = $this->getall("deposit", "userID = ? and status = ?", [$userID, $status], fetch: "moredetails");
                }
                if($data->rowCount() == 0) { return $info = ['data'=>[], 'number'=>0, 'total'=>0];}
                $info['total'] = 0;
                $info['data'] = $data;
                $info['number'] = $data->rowCount();
                foreach($data as $row) {
                    $info['total'] = $info['total'] + (float)$row['amount'];
                }
                // var_dump($total_amount);
                return $info;

        }
        function get_deposit_max($userID) {
            $check = $this->getall("deposit", "userID = ? and status = ?", [$userID, "pending"], fetch: "");
            if($check > $this->get_settings("deposit_max") || $check == $this->get_settings("deposit_max")) {
                return true;
            }
            return false;
        }
    }
<?php
class investment extends user
{

    // generate daily notification 
    function daily_report_notification($userID = "",  $date = null) {
        if($date == null) {$date  = date("Y-m-d");}
        // generate notification
        // message: Our AI Bot general report for today (10-09-2023)
        // Trades taken: 
        // profit:
        // lost: 
        // check if report already exit   
            if($this->getall("notifications", "userID = ? and n_for = ? and date_set = ?", ["all", "global_report", $date], fetch: "") == 0){
                $tr = $this->get_trade_report(date: $date, type: "global");
                $data = [];
                $data['userID'] = "all";
                $data['n_for'] = "global_report";
                $data['title'] = "Our AI bot general report for today ($date)";
                $data['description']  = "Trade(s): ".number_format($tr['trade_no'])." Profit: ".$this->money_format($tr['profit'], currency ?? "$")." Lost: ".$this->money_format($tr['lost'], currency ?? "$");
                $data['time_set'] = time();
                $data['date_set'] = $date;
                $data['url'] = ROOT."index?type=global&p=investment&action=trades&date=$date";
                $this->new_notification($data);
                // send email to user's email.
                $message = $this->replace_word([' ${first_name}'=>"", '${message_here}'=>$data['description']], $this->get_email_template("default")['template']);
                $sendmessage = $this->smtpmailer($this->get_all_emails(), $data['title'], $message);
            }
           
        // user notification
        // message: Trades taken on your account for today (10-09-2023)
        if($userID != "") {
            if($this->getall("notifications", "userID = ? and n_for = ? and date_set = ?", [$userID, "my_report", $date], fetch: "") > 0) {
                return false;
            }
            $tr = $this->get_trade_report(uid: $userID, date: $date, type: "");
            $data = [];
            $data['userID'] = $userID;
            $data['n_for'] = "my_report";
            $data['title'] = "Trades taken on your account for today ($date)";
            $data['description']  = "Trade(s): ".number_format($tr['trade_no'])." Profit: ".$this->money_format($tr['profit'], currency ?? "$")." Lost: ".$this->money_format($tr['lost'], currency ?? "$");
            $data['time_set'] = time();
            $data['date_set'] = $date;
            $data['url'] = ROOT."index?type=&p=investment&action=trades&date=$date";
            $this->new_notification($data);
            // send email to users
            $message = $this->replace_word([' ${first_name}'=>$this->get_name($data['userID']), '${message_here}'=>$data['description']], $this->get_email_template("default")['template']);
            $sendmessage = $this->smtpmailer($this->get_all_emails(), $data['title'], $message);
           
        }

    }

    function get_trade_report($uid = "", $date = "",  $type = "global") {
        $more = "";
        $more_value = "";
        $userinfo = "userID = ? and ";
        if($type == "global") {
            $userinfo = "";
            $uid = "";
        }

    
        if($date != "") {
          $date = htmlspecialchars($_GET['date']);
          $more = "trade_date = ? and ";
          $more_value = $date;
        }
        $trades = $this->getall("trades", "$userinfo $more  status = ?  order by trade_time DESC", array_values(array_filter([$uid, $more_value, "closed"], 'strlen')), fetch: "moredetails");
        $lost = $this->getall("trades", "$userinfo  intrest_amount < ? and $more  status = ?  order by trade_time DESC", array_values(array_filter([$uid, 0, $more_value, "closed"], 'strlen')), "SUM(intrest_amount) as amount");
        $profit = $this->getall("trades", "$userinfo  intrest_amount > ? and $more  status = ?  order by trade_time DESC", array_values(array_filter([$uid, 0, $more_value, "closed"], 'strlen')), "SUM(intrest_amount) as amount");
        $trade_no = $trades->rowCount();
        return ["trades"=>$trades, "lost"=>$lost, "profit"=>$profit, "trade_no"=>$trade_no];
    }

    function new_investment($data, $type = "tranding_balance")
    {
        $_POST['ID'] = uniqid();
        if (!is_array($data)) {
            echo $this->message("Err: No data passed.", "error");
            return null;
        }
        $info = $this->validate_form($data);
        if (!is_array($info)) {
            return null;
        }
        $user = $this->getall("users", 'ID = ?', [$info['userID']], "balance, trading_balance");
        // var_dump($user);
        if (!is_array($user)) {
            $this->message("User Not found", "error");
            return null;
        }
        $url = "?p=investment&action=view&id=".$info['ID'];
        if ((float)$info['amount'] > (float)$user['trading_balance']) {
            if($type == "quick") {
                $info['status'] = "pending";
                $url = "index?p=deposit&action=new&amount=".$info['amount'];
            }else{
                echo $this->message("You do not have enough in your trading account. <a href='index?p=deposit&action=new'>Make a deposit</a> or <a href='#' class='btn text-primary' data-url=\"modal?p=investment&action=transfer&funds_to=trading_account\" data-title=\"Transfer Funds\" onclick=\"modalcontent(this.id)\" data-bs-toggle=\"modal\" data-bs-target=\"#bs-example-modal-md\" id='transfer-modal'>transfer</a> from your balance to your trading account", "error");
                return null;
            } 
        }
        if (!$this->check_plan($info['planID'], $info['amount'])) {
            // $this->message("This plan is no more active", "error");
            return null;
        }
        $info['trade_amount'] = $info['amount'];
        $insert = $this->quick_insert("investment", $info);
        if (!$insert) {
            $this->message("We are having issue creating your plan.", "error");
            return null;
        }
        $actInfo = ["userID" => $info['userID'],  "date_time" => date("Y-m-d H:i:s"),"action_name" => "Create Investment", "description" => "An investment of ".$this->money_format($info['amount'], currency)." was created.", "action_for"=>"investment", "action_for_ID"=>$info['ID']];
        $this->new_activity($actInfo);
        $userID = $info['userID'];
        if($type != "quick") {
            $new_balance =  (float)$user['trading_balance'] - (float)$info['amount'];
            $update = $this->update("users", ['trading_balance' => $new_balance], "ID = '$userID'"); 
        }
        
        $id = $info['ID'];
        $return = [
            "message" => ["Sucess", "Invesment Plan created successfully.", "success"],
            "function" => ["loadpage", "data" => ["$url", "success"]],
        ];
        return json_encode($return);
    }

    

    function activate_compound_profits($data)
    {
        $info = $this->validate_form($data, "compound_profits_assigned");
        if (!is_array($info)) {
            return;
        }
        $roll = $this->getall("compound_profits", "ID = ? and status = ?", [$info['compound_profits'], "active"]);
        if (!is_array($roll)) {
            $this->message("Compound profits deleted or not active anymore", "error");
            return;
        }
        //  debit amount
        if (!$this->credit_debit($info['userID'], $roll['purchase_price'], "balance", "debit")) {
            return;
        }
        //   credit profit
        $check = $this->getall("compound_profits_assigned", "userID = ?", [$info['userID']]);
        if ($check == 0) {
            if (!$this->credit_debit($info['userID'], $roll['bonus_price'], "trade_bonus")) {
                return;
            }
        }

        $insert = $this->quick_insert("compound_profits_assigned", $info, "Compound profits assigned to investment successfully");
        if($insert) {
            $actInfo = ["userID" => $info['userID'],  "date_time" => date("Y-m-d H:i:s"),"action_name" => "compound_profits Activated", "description" => "A compound_profits was actiaved on an investment.", "action_for"=>"compound_profits_assigned", "action_for_ID"=>$info['ID']];
        $this->new_activity($actInfo);
        }
    }

    function pause_compound_profits($id, $status = null, $userID = "admin")
    {
        if($status != "active" &&  $status != "deactive" && $status != null) {
            return null;
        }
        $data = $this->getall("compound_profits_assigned", "ID = ? and userID = ?", [$id, $userID]);
        if (!is_array($data)) {
            return null;
        }
        if ($status == null) {
            if ($data['status'] == 'active') {
                $status = "deactive";
            } else {
                $status = "active";
            }
        }
        $update = $this->update("compound_profits_assigned", ["status" => $status], "ID = '$id'");
        if($update) {
            $actInfo = ["userID" => $userID,  "date_time" => date("Y-m-d H:i:s"),"action_name" => "compound_profits $status", "description" => "A compound_profits was set to be $status.", "action_for"=>"compound_profits_assigned", "action_for_ID"=>$id];
            $this->new_activity($actInfo);
        }
    }

    function get_compound_profits($investID) {
        $data = $this->getall("compound_profits_assigned", "investmentID = ?", [$investID]);
        if(!is_array($data)) { return false; }
        return $data;
    }
    function apply_compound_profits()
    {
    }

    function apply_weekly_compound_profits()
    {
        if (date("N") == 7) {
            $date = date("Y-m-d");
            $time = date("H:i:s");
            $compound_profits = $this->getall("
            compound_profits_assigned 
            JOIN compound_profits ON compound_profits_assigned.compound_profits = compound_profits.ID AND compound_profits.assigned_users LIKE CONCAT('%', compound_profits_assigned.userID, '%')
            ", "compound_profits_assigned.last_date <= ? and compound_profits_assigned.status = ? and compound_profits.type = ?", [$date, 'active', 'weekly'], "compound_profits_assigned.ID as compound_profits_assignedID, compound_profits_assigned.investmentID as investmentID, compound_profits_assigned.userID as userID", fetch: "moredetails");
            if ($compound_profits->rowCount() == 0) {
                return true;
            }

            $lastMonday = date("Y-m-d", strtotime("last Monday"));
            $lastSaturday = date("Y-m-d", strtotime("last Saturday"));
            foreach ($compound_profits as $row) {
                $sum = $this->getall("trades", "investmentID = ? and intrest_amount > ? and trade_date >= ? and trade_date <= ?", [$row['investmentID'],  0, $lastMonday, $lastSaturday], "userID as userID, SUM(intrest_amount) as total_intrest");
                $investID = $row['investmentID'];
                $invest = $this->getall("investment", 'ID = ?', [$investID], 'trade_amount');
                $trade_amount = (float)$invest['trade_amount'] + (float)$sum['total_intrest'];
                $update = $this->update("investment", ["trade_amount" => $trade_amount], "ID  = '$investID'");
                if (!$update) {
                    continue;
                }
                // Debit fund from trading_balance 
                $update = $this->credit_debit($sum['userID'], $sum['total_intrest'], "trading_balance", 'debit');
                // UPDATE DATE FOR THE compound_profits
                if ($update) {
                    $id = $row['compound_profits_assignedID'];
                    $this->update("compound_profits_assigned", ["last_date" => $date, "last_time" => $time], "ID = '$id'");
                    $actInfo = ["userID" => $row['userID'],  "date_time" => date("Y-m-d H:i:s"),"action_name" => "compound_profits Applied", "description" => "Weekly compound_profits applied on your investment with the ID: ".$row['investmentID'], "action_for"=>"compound_profits_assigned", "action_for_ID"=>$row['ID']];
                    $this->new_activity($actInfo);
                }
                // $total_trades = $this->getall("trades", "");
                // $trades = $this->get_all_trades_btw_dates($lastMonday, $lastSaturday, $row['investmentID']);
            }
        }
    }

    function apply_daily_compound_profits()
    {
        $today =  date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $time = date("H:i:s");
        $compound_profits = $this->getall("
        compound_profits_assigned 
        JOIN compound_profits ON compound_profits_assigned.compound_profits = compound_profits.ID AND compound_profits.assigned_users LIKE CONCAT('%', compound_profits_assigned.userID, '%')
        ", "compound_profits_assigned.last_date <= ? and compound_profits_assigned.status = ? and compound_profits.type = ?", [$today, 'active', 'daily'], "compound_profits_assigned.ID as compound_profits_assignedID, compound_profits_assigned.investmentID as investmentID, compound_profits_assigned.userID as userID", fetch: "moredetails");
        if ($compound_profits->rowCount() == 0) {
            return true;
        }
        foreach ($compound_profits as $row) {
            $sum = $this->getall("trades", "investmentID = ? and intrest_amount > ? and trade_date = ?", [$row['investmentID'],  0, $yesterday], "userID as userID, SUM(intrest_amount) as total_intrest");
            if (!is_array($sum) || $sum['total_intrest'] < 1) {
                continue;
            }
            $investID = $row['investmentID'];
            $invest = $this->getall("investment", 'ID = ?', [$investID], 'trade_amount');
            $trade_amount = (float)$invest['trade_amount'] + (float)$sum['total_intrest'];
            $update = $this->update("investment", ["trade_amount" => $trade_amount], "ID  = '$investID'");
            if (!$update) {
                continue;
            }
            // Debit fund from trading_balance 
            $update = $this->credit_debit($sum['userID'], $sum['total_intrest'], "trading_balance", 'debit');
            // UPDATE DATE FOR THE compound_profits
            if ($update) {
                $id = $row['compound_profits_assignedID'];
                $this->update("compound_profits_assigned", ["last_date" => $today, "last_time" => $time], "ID = '$id'");
                $actInfo = ["userID" => $row['userID'],  "date_time" => date("Y-m-d H:i:s"),"action_name" => "compound_profits Applied", "description" => "Daily compound_profits applied on your investment with the ID: ".$row['investmentID'], "action_for"=>"compound_profits_assigned", "action_for_ID"=>$row['compound_profits_assignedID']];
                $this->new_activity($actInfo);
            }
            // $total_trades = $this->getall("trades", "");
            // $trades = $this->get_all_trades_btw_dates($lastMonday, $lastSaturday, $row['investmentID']);
        }
    }
    private function get_all_sum_trades_btw_dates($start, $end, $investID = "all")
    {
    }
    function get_user_roll_over($userID)
    {
        $data = $this->getall("compound_profits", "assigned_users LIKE '%$userID%' and status = ?", ["active"], fetch: "moredetails");
        if ($data->rowCount() == 0) {
            return [];
        }
        $info = [];
        foreach ($data as $row) {
            $info[$row['ID']] = ucfirst($row['type']) . ' Compound Profits - Purchase Price: ' . $this->money_format($row['purchase_price'], currency) . ' <b class="text-success">(Bonus of: ' . $this->money_format($row['bonus_price'], currency) . ")</b>";
        }
        return $info;
    }

    private function check_if_user_in_compound_profits($rollID, $userID)
    {
        $check = $this->getall("compound_profits", "ID = ? and assigned_users LIKE '%$userID%' and status = ?", [$rollID, "active"], fetch: "");
        if ($check > 0) {
            return true;
        }
        return false;
    }
    function invest_data($userID)
    {
        $info = [];
        $data = $this->getall("investment", "userID = ?", [$userID], "SUM(amount) as total_amount");
        $info['invest_amount'] = $data['total_amount'];
        $data = $this->getall("investment", "userID = ? and status =? ", [$userID, "active"], "COUNT(*) as active_invest");
        $info['active_invest'] = $data['active_invest'];


        // $info['invest_num'] = $invest->rowCount();
        // $info['invest_amount'] = 0;
        // $info['invest_active'] = 0;
        // $info['invest_close'] = 0;
        // foreach($invest as $row) {
        //     $info['invest_amount'] = $info['invest_amount'] + (float)$row['amount'];
        //     if(isset($info['invest_'.$row['status']])){
        //         $info['invest_'.$row['status']] = $info['invest_'.$row['status']] + 1;
        //     }

        // }
    }
    function extract_chart_data($data, $date = null)
    {
        if ($date == null && isset($data[0])) {
            $holder = json_decode($data[0]['trade_candles']);
            // echo "yes";
            var_dump($holder[0][0]);
            $chart_info = [[$holder[0][0], 0]];
        } else {
            $chart_info = [[$date, 0]];
        }

        // if($data->rowCount() == 0 && !is_array($data)) { return $chart_info;}
        // $i = 0;

        foreach ($data as $row) {
            $candles = json_decode($row['trade_candles']);
            $no =  count($candles) - 1;
            $time = $candles[0][0];
            $interest = $row['intrest_amount'];
            $chart_info[] = [$time, $interest];

            // var_dump(json_encode($chart_info));
            // echo $row['ID']."<br>";
            // echo date("Y-m-d H:i:s", '1633417200000' / 1000)."<br>";
            // echo date("Y-m-d H:i:s", '1693597137');
            // echo "<hr>";
        }
        return $chart_info;
    }
    function check_plan($planID, $amount)
    {
        $plan = $this->getall("plans", "ID = ?", [$planID]);
        // $this->message("This plan is no more active", "error");
        if (!is_array($plan)) {
            return false;
        }
        if ($plan['status'] != "active") {
            $this->message("This plan is no more active", "error");
            return false;
        }
        if ((float)$plan['min_amount'] > (float)$amount) {
            $this->message("The minimum amount for this plan is " . $this->money_format($plan['min_amount']), "error");
            return false;
        }
        if ($plan['max_amount'] != 0 &&  (float)$amount > (float)$plan['max_amount']) {
            $this->message("The maximum amount for this plan is " . $this->money_format($plan['max_amount']), "error");
            return false;
        }
        return true;
    }

    function credit_bot() {

    }
    function invetment_bot()
    {
        $bots = $this->getall("users", "acct_type = ?  and status = ?", ['bot', 'active'], fetch: "moredetails");
        if($bots->rowCount() < 1) { return false; }
        foreach($bots as $bot) {
            // select a radom plan 
            // 
            // generate rondom amount
            // check of amount  is in trading balance  if not crediit the amount
            // 
            // $investment_form = [
            //     "ID"=>["input_type"=>"hidden"],
            //     "planID"=>["input_type"=>"hidden"],
            //     "userID"=>["input_type"=>"hidden",],
            //     "amount"=>["input_type"=>"number", "description"=>"What is the amount you want to invest in this plan? ($currency)", "placeholder"=>"100"],
            // ];
            
            $_POST['ID'];
        }
    }

    function auto_genarate_trading_days()
    {

        $today = date("Y-m-d");
        // get all active investments  
        $plans = $this->get_plan("active");
        if ($plans->rowCount() == 0) {
            return true;
        }
        // insert into database as pending trade
        foreach ($plans as $row) {
            // check if investment is not in trades where date is equals today
            $check = $this->getall("trades", "investmentID = ? and trade_date = ?", [$row['ID'], $today], fetch: "");
            // var_dump($check);
            if ($check > 0) {
                continue;
            }
            $times = $this->get_times();
            foreach ($times as $key => $value) {
                $this->quick_insert("trades", ["investmentID" => $row['ID'], "userID" => $row['userID'], "trade_date" => $today, "trade_time" => $value]);
            }
        }
        // $form = [
        //     "ID"=>["input_type"=>"number"],
        //     "investmentID"=>[],
        //     "amount"=>["input_type"=>"number"],
        //     "trade_date"=>[],
        //     "trade_time"=>[],
        //     "status"=>[],
        // ];
        // $this->create_table("trades", $form);

    }

    function get_plan($status)
    {
        return $this->getall("investment", "status = ? order by date ASC", [$status], fetch: "moredetails");
    }

    function take_pending_trades()
    {
        $coins = $this->get_settings("trade_coins");
        $coins = explode(",", $coins);
        // var_dump($coins[array_rand($coins)]."USDT");
        // get all pending plans where date less or equal today
        $today = date("Y-m-d");
        //$trades = $this->getall("trades", 'status = ? order by trade_time ASC LIMIT 50', ["pending"], fetch: "moredetails");
        $trades = $this->getall("trades", 'trade_date <= ? and trade_time < ? and status = ? order by trade_time ASC LIMIT 20', [$today, time(), "pending"], fetch: "moredetails");
        // $trades = $this->getall("trades", 'trade_candles = ? or trade_candles = ?', ["", null], fetch: "moredetails");
        // var_dump($trades->rowCount());
        if ($trades->rowCount() == 0) {
            return true;
        }
        $totals = [];
        $limitvalue = rand(10, 30);
        $inters = ["1m", "5m", "15m", "30m", "45m", "1h"];
        $interval = $inters[array_rand($inters)];
        if($interval == "45m" || $interval == "1h" || $interval == "30m") {
            $limitvalue = rand(2, 4);
        }
        $coins = $this->get_settings("trade_coins");
        $coins = explode(",", $coins);
        $i = 0;
        foreach ($trades as $row) {
            $id = $row['ID'];
            if (!isset($totals[$row['investmentID']])) {
                $totals[$row['investmentID']] = [];
            }
            if (isset($totals[$row['investmentID']][$row['trade_date']]) && $totals[$row['investmentID']][$row['trade_date']] == "closed") {

                continue;
            }
            $startTimestamp = (int)$row["trade_time"] * 1000;
            // echo "<br>";
            $coin = trim($coins[array_rand($coins)])."USDT";
            // $data https://api-testnet.bybit.com/v5/market/kline?category=inverse&symbol=$coin&interval=$interval&start=$startTimestamp&limit=$limitvalue
            $data = $this->api_call("https://api.binance.com/api/v3/klines?symbol=$coin&interval=$interval&limit=$limitvalue&startTime=$startTimestamp");
            // $data = $this->api_call("https://api-testnet.bybit.com/v5/market/kline?category=inverse&symbol=$coin&interval=$interval&start=$startTimestamp&limit=$limitvalue");
            if (!is_array($data) || count($data) < $limitvalue) {
                // var_dump($data);
                // echo "https://api.binance.com/api/v2/klines?symbol=$coin&interval=$interval&limit=$limitvalue&startTime=$startTimestamp";
                echo $i++." ID: ".$row['ID']." error Date: ".$row['trade_date'];
                // echo "https://api-testnet.bybit.com/v5/market/kline?category=inverse&symbol=$coin&interval=$interval&start=$startTimestamp&limit=$limitvalue";
                 echo "<br>";
                continue;
            }
            // echo var_dump($this->get_times());
            // echo "https://api.binance.com/api/v3/klines?symbol=$coin&interval=$interval&limit=$limitvalue&startTime=$startTimestamp";
            // var_dump($data);
            // return;
            $info = $this->cal_trade_percent($data, $row);
            if (!is_array($info)) {
                continue;
            }
            $info['coinname'] = $coin;
            $info['status'] = "closed";
            if (!isset($totals[$row['investmentID']][$row['trade_date']])) {
                $totals[$row['investmentID']][$row['trade_date']] = $this->total_daily_profit($row['investmentID'], $row['trade_date']);
            }

            if ($totals[$row['investmentID']][$row['trade_date']] >= $this->get_investment_max_profit($row['investmentID'])) {
                $this->close_all_pending_trades($row['investmentID'], $row['trade_date']);
                $totals[$row['investmentID']][$row['trade_date']] =  "closed";
                continue;
            }
            $totals[$row['investmentID']][$row['trade_date']] = $totals[$row['investmentID']][$row['trade_date']] + $info['intrest_amount'];
            // var_dump($info);
            $update = $this->update("trades",  $info, "ID = '$id'",);
            if ($update) {
                $date = $this->date_format(date("Y-m-d H:i:s", $row['trade_time']  / 1000));
                $actInfo = ["userID" => $row['userID'],  "date_time" => date("Y-m-d H:i:s"),"action_name" => "New trade taken", "description" => "A new trade was taken on your investment with an intrest of ".$info['percentage'], "action_for"=>"trades", "action_for_ID"=>$id];
                $this->new_activity($actInfo);
                $update = $this->credit_debit($row['userID'], $info['intrest_amount'], "trading_balance");
                echo "Success: for ".$row['ID']." <br>";
            }
            // echo "success: ".$row['investmentID']." <br>";
            // foreach ($data as $row) {
            // echo   $row[0];
            // $start_time = date("Y-m-d H:i:s", $row[0] / 1000);
            // $end_time = date("H:i:s", $row[6] / 1000);
            // echo 'Start Time: ' . $start_time . "<br>";
            // echo 'End Time: ' . $end_time . "<hr>";
            // }

        }
        // var_dump($totals);


        // $start = '2022-08-31 12:00:00';
        // $startTimestamp = strtotime($start) * 1000;
        // $data = $this->api_call("https://api.binance.com/api/v3/klines?symbol=ETHUSDT&interval=1d&limit=20&startTime=$startTimestamp");
        // $this->cal_trade_percent($data, 19);
        // var_dump($data);
        // echo "<br>";
        // foreach($data as $row) {
        //     // echo   $row[0];
        //     $start_time = date("Y-m-d H:i:s", $row[0] / 1000);
        //     $end_time = date("H:i:s", $row[6] / 1000);
        //     echo 'Start Time: '.$start_time ."<br>";
        //     echo 'End Time: '.$end_time ."<hr>";

        // }
        echo $this->message("done", "success");
    }

    function get_all_trades()
    {
    }
    function close_all_pending_trades($investID, $date)
    {
        $update = $this->delete("trades", "investmentID = ? and trade_date = ? and status = ? ", [$investID, $date, "pending"]);
        if (!$update) {
            return false;
        }
        return true;
    }
    function get_investment_max_profit($investID)
    {
        $invest = $this->getall("investment", "ID = ?", [$investID], "planID");
        if (!is_array($invest)) {
            return 0;
        }
        $plan = $this->getall("plans", "ID = ?", [$invest['planID']], "return_range_from, return_range_to, retrun_interval");
        if (!is_array($invest)) {
            return 0;
        }
        return  (float)$plan['return_range_to'];
    }

    function total_daily_profit($investID, $date)
    {
        $trades = $this->getall("trades", 'investmentID = ? and trade_date = ? and status = ?', [$investID, $date, 'closed'], "SUM(percentage) as percentage", fetch: "details");
        if (!is_array($trades)) {
            return 0;
        }
        $total = $trades['percentage'];
        return $total;
    }

    function total_profit($investID, $date = "all", $return_type = "all")
    {
        $info = ["total" => 0, "percentage" => 0];
        if ($date == "all") {
            $trades = $this->getall("trades", 'investmentID = ? and status = ?', [$investID, "closed"], "intrest_amount, percentage", fetch: "moredetails");
        } else {
            $trades = $this->getall("trades", 'investmentID = ? and trade_date = ? and status = ?', [$investID, $date, "closed"], "intrest_amount, percentage", fetch: "moredetails");
        }
        if ($trades->rowCount() == 0) {
            return $info;
        }
        foreach ($trades as $row) {
            $info['total'] = $info['total'] + (float)$row['intrest_amount'];
            $info['percentage'] = $info['percentage'] + $row['percentage'];
        }
        if ($return_type == "all") {
            return $info;
        }
        if (isset($info[$return_type])) {
            return $info[$return_type];
        }
        return 0;
    }



    function cal_trade_percent($data, $trade)
    {
        $x = 1;
        $open_price = $data[0][1];
        $close_price = $data[count($data) - 1][1];
        // echo $this->calculateProfitPercentage($open_price, $close_price) . "% <br>";
        // echo "$open_price" . "<br>";
        // echo "$close_price" . "<br>";
        $n1 = $open_price;
        $n2 = $close_price;
        $trade_type = "buy";
        $percentage = (float)$this->calculateProfitPercentage($n1, $n2);

        if ($percentage < 0 && $percentage > (-0.9)) {
            if ($this->no_of_lost($trade['investmentID'], $trade['trade_date']) > 2) {
                return null;
            }
            $x = rand(1, 3);
        } else if ($open_price > $close_price) {
            $trade_type = "sell";
            $n1 = $close_price;
            $n2 = $open_price;
            $percentage = (float)$this->calculateProfitPercentage($n1, $n2);
        } else if ((int)$percentage < 0) {
            return ["intrest_amount" => 0, "trade_candles" => null, "percentage" => 0, "trade_type" => null];
            // return null;
        }
        if ($percentage > 0 && $percentage < 3) {
            if ($percentage < 1) {
                $x = rand(5, 10);
            } else {
                $x = rand(2, 8);
            }
        }
        $percentage = $percentage * $x;
        $trade_amount = $this->get_invest_trade_amount($trade['investmentID']);
        $amount = $this->calculateIncreasedValue($trade_amount, $percentage);
        return ["amount" => $trade_amount, "intrest_amount" => $amount, "trade_candles" => json_encode($data), "percentage" => $percentage, "trade_type" => $trade_type, "Xtrade" => $x];
    }

    function get_invest_trade_amount($investID)
    {
        $check = $this->getall("investment", "ID = ?", [$investID], "trade_amount");
        if (!is_array($check)) {
            return 0;
        }
        return (float)$check['trade_amount'];
    }
    function no_of_lost($id, $date)
    {
        $check = $this->getall("trades", "investmentID = ? and date = ? and percentage < ?", [$id, $date, 0], fetch: "");
        return $check;
    }
    function get_times()
    {
        // genrate roundam time today in x time, time should be btw one hour away and the rest of the day
        // $now = time() + 900;
        $now = strtotime('today');
        //  $now = strtotime("-2 day");
        $random_time = [];
        $endOfDay = strtotime('tomorrow') - 1;
        $endOfDay = time();
        for ($i = 0; $i < rand(10, 20); $i++) {
            $random_time[] = rand($now, $endOfDay);
        }
        // var_dump($random_time);
        return $random_time;
    }
}
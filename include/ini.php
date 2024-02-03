<?php 
require_once "include/session.php";
if(isset($_GET['theme'])) {
    setcookie('browser_theme', null, time() - 3600, '/');
    $expiration = time  () + (365 * 24 * 60 * 60); // 100 days * 24 hours * 60 minutes * 60 seconds
    if($_GET['theme'] == "dark") {
        // Set the cookie
        setcookie("browser_theme", "dark", $expiration, "/", "");
        
    } else{
        // exit();
        setcookie("browser_theme", "light", $expiration, "/", "");
        // setcookie("browser_theme", "light", $expiration, "/");    
    }
    // Get the previous page link
$previousPage = $_SERVER['HTTP_REFERER'];
    // Reload the current page
echo '<script>window.location.href = "'.$previousPage.'";</script>';
exit();
}
require_once "include/side.php";

require_once "consts/main.php";
require_once "consts/Regex.php";
require_once "admin/include/database.php"; 
$d = new database;
require_once "consts/general.php";
require_once "content/content.php"; 
require_once "functions/notifications.php"; 
require_once "functions/users.php"; 
$u = new user;
$c = new content;
$n = new Notifications;

$page = "dashboard";
if(isset($_GET['p'])) {
    $page = htmlspecialchars($_GET['p']);
}
$script = [];
$user = $d->getall("users", "ID = ?",  [$userID], fetch:"details");
$full_name = ucwords($user['first_name'].' '.$user['last_name']);
$user_data = $u->user_data($userID);
$activities = $d->getall("activities", "userID = ? order by date DESC LIMIT 5", [$userID], fetch: "moredetails");
$act_title = 'Recent Activity';
$act_des = 'New notifications and activity on your account';
$invest_no = $d->getall("investment", "userID = ?", [$userID], fetch: '');
$deposit = $d->getall("deposit", "userID = ?", [$userID], fetch: '');
if($invest_no <= 0 && $deposit <= 0) {
    $_SESSION['newuser'] = $userID;
}elseif(isset($_SESSION['newuser'])){
    unset($_SESSION['newuser']);
}

if(isset($_GET['note']) && $_GET['note'] != "") {
    $n->exclude_user(htmlspecialchars($_GET['note']), $userID);
}   
$upromo = $d->getall("promo", "assigned_users LIKE '%$userID%' and status = ? order by rate DESC", ["active"], fetch: "details");
// echo $userID;
// var_dump($u->get_all_emails());
// exit;

$form_trans = [
    "ID"=>["input_type"=>"number"],
    "userID"=>[],
    "forID"=>["is_required"=>false],
    "trans_for"=>["is_required"=>false],
    "action_type"=>[],
    "acct_type"=>[],
    "amount"=>["input_type"=>"number"],
    "current_balance"=>["input_type"=>"number"],
];
$d->create_table("transactions", $form_trans);

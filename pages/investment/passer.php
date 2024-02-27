<?php 
if(isset($_POST['top_up'])){
    echo $i->topup_investment($userID, $topup_form);
}

?>
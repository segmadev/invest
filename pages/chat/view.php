<?php 
    if(isset($_GET['userid'])) {
        $user2 = htmlspecialchars($_GET['userid']);
        if($user2 != $userID){
                $ch->new_user_chat($userID, $user2, $chat_form);
                $ch->new_user_chat($userID, $user2, $chat_form);
        }
    }

    if(isset($_GET['groupID'])) {
        $groupID = htmlspecialchars($_GET['groupID']);
        $data = $d->getall("chat", "user1 = ? and user2 = ?", [$userID, $groupID]);
        if(is_array($data)) { 
            $d->loadpage("index?p=chat&id=".$data['ID']);
        }
    }
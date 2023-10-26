<?php 
    $script[] ="modal";
    $script[] ="sweetalert";
?>
<div class="col-12 d-flex row">
    <div class="col-12 col-md-3 <?php if(isset($_GET['id'])){ echo "d-none d-sm-none d-md-block"; } ?>">
        <?php require_once "pages/chat/chat-list.php"; ?>
    </div>
    <div class="col-12 col-md-9 <?php if(!isset($_GET['id'])){ echo "d-none d-sm-none d-md-block"; } ?>">
        <?php 
        if(isset($chatID)) {
            require_once "pages/chat/messages.php"; 
        }else{
           echo $c->empty_page("No chat selected. Please select a chat first.", h1: "No chat.", icon: "<i class='ti ti-message text-warning h1'></i>");
        }
        ?>
        
    </div>
</div>

<!-- show: app-chat-offcanvas border-start app-chat-right -->
<!-- not show: app-chat-offcanvas border-start -->
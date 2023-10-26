<?php require_once "content/header.php";
if($page != ""){
    require_once "pages/page-ini.php";
}

?>
<script>
    if ('Notification' in window) {
        Notification.requestPermission().then(function(permission) {
            if (permission === 'granted') {
                if(new Notification('Notification Title', {body:  "welcome"})) {
               console.log(permission);
           }
          }
        });
      }
</script>
<?php require_once "content/footer.php"; ?>


<?php
     const db_username = "prolcnoz_public";
     const db_password = "sJjJzBeJx2Qx";
     const db_name = "prolcnoz_db";
     const db_host_name = "localhost";
     define("rootFile", str_replace("C:/xampp2/htdocs/invest2", "C:/xampp2/htdocs/invest2/app", $_SERVER['DOCUMENT_ROOT']."/invest2/"));
     if (strpos(rootFile, "C:/xampp2/htdocs/") == false){
        define("rootFile", str_replace("invest2", "", rootFile));
     }


    //  const db_username = "root";
    //  const db_password = "";
    //  const db_name = "invest";
    //  const db_host_name = "localhost";
?>
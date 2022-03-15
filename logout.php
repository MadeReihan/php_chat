<?php 

    session_start();

    session_unset();
    session_destroy();


    $em = "Logout Successful";

    header("Location: index.php?success=$em");
    exit;

?>
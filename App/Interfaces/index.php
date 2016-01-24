<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");

    SessionManager::validateUserInPage('index.php');

    $string = file_get_contents("template/index.html");
    echo $string;
 ?>
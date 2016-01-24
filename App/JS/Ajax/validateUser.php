<?php 
    
    require_once(__DIR__."/../../../Backend/SessionManager.php");

    if (!isset($_GET) || $_GET["username"] === NULL)
    {
        echo "KO";
        die;
    }

    $username = $_GET["username"];
    $password = $_GET["password"];

    $userDate = SessionManager::validateUser($username, $password);

    if ($userDate !== NULL)
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
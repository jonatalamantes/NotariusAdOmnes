<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_GET) || $_GET["nameDean"] === NULL)
    {
        echo "KO";
        die;
    }

    $dean = new Dean(0, $_GET["nameDean"]);

    if (ChurchManager::addDean($dean))
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
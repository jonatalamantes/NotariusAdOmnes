<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_GET) || $_GET["rector"] === NULL)
    {
        echo "KO";
        die;
    }
    
    //Get The Objects    
    $church = ChurchManager::getSingleChurch('name', $_GET["church"]);

    if (RectorManager::addFormerRectorChurch($_GET["rector"], $church->getId()))
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
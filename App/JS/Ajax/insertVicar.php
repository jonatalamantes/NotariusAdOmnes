<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_GET) || $_GET["nameVicar"] === NULL)
    {
        echo "KO";
        die;
    }

    $vicar = new Vicar(0, $_GET["nameVicar"]);

    if (ChurchManager::addVicar($vicar))
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
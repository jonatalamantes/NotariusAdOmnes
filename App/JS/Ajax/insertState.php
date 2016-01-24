<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/CityManager.php");

    if (!isset($_GET) || $_GET["nameState"] === NULL)
    {
        echo "KO";
        die;
    }

    $state = New State();

    $state->setName($_GET["nameState"]);
    $state->setShortName($_GET["shortState"]);
    $state->setCountry($_GET["country"]);

    if (CityManager::addState($state))
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
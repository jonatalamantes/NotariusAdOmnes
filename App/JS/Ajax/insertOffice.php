<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/CityManager.php");
    require_once(__DIR__."/../../../Backend/BaptismManager.php");

    if (!isset($_GET) || $_GET["cityName"] === NULL)
    {
        echo "KO";
        die;
    }

    $city = CityManager::getSingleCity('name', $_GET["cityName"]);
    $number = $_GET["numberCivil"];

    $office = new OfficeCivilRegistry(0, $number, $city->getId());

    if (BaptismManager::addOfficeCivilRegistry($office))
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
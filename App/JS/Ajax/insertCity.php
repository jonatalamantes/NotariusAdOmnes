<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/CityManager.php");

    if (!isset($_GET) || $_GET["nameCity"] === NULL)
    {
        echo "KO";
        die;
    }

    $city = new City(0, $_GET["nameCity"], CityManager::getSingleState('name', 
                                                                       $_GET["state"])->getId() );

    if (CityManager::addCity($city))
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
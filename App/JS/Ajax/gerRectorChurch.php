<?php 
    
    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");

    if (!isset($_GET) || $_GET["nameChurch"] === NULL)
    {
        die;
    }

    $church  = ChurchManager::getSingleChurch('name', $_GET["nameChurch"]);
    $rectors = RectorManager::getAllFormerRectors($church->getId());

    $response = "";

    if ($rectors !== NULL)
    {
        foreach ($rectors as $singleRector) 
        {
            $person     = PersonManager::getSinglePerson('id', $singleRector->getIdPerson());
            $nameRector = $person->getFullNameBeginName();

            $response = $response . "<li><a value='" . $singleRector->getId() . 
                                    "' onclick='changeParent(\"" . $singleRector->getId() . "\", ". 
                                    " \" " . $nameRector . " \")'>" .
                                    "$nameRector</a></li>";
        }
    }

    echo $response;

 ?>
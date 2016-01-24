<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");

    if (!isset($_GET) || $_GET["name"] === NULL)
    {
        echo "KO";
        die;
    }

    $status = $_GET["status"];
    $rector = New Rector();

    $person = PersonManager::getSinglePerson('names',     $_GET["name"], 
                                             'lastname1', $_GET["lastname1"], 
                                             'lastname2', $_GET["lastname2"]);

    if ($person === NULL)
    {
        $person = New Person(0, $_GET["name"], $_GET["lastname1"], $_GET["lastname2"]);
        PersonManager::addPerson($person);

        $person = PersonManager::getSinglePerson('names',     $_GET["name"], 
                                                 'lastname1', $_GET["lastname1"], 
                                                 'lastname2', $_GET["lastname2"]);

    }

    $church = ChurchManager::getSingleChurch('name', $_GET["actualChurch"]);

    $rector->setIdPerson($person->getId());
    $rector->setType($_GET["type"]);
    $rector->setPosition($_GET["position"]);
    $rector->setIdActualChurch($church->getId());

    if ($_GET["statusR"] === 'Activo' || $_GET["statusR"] === 'Active')
    {
        $rector->setStatus('A');    
    }
    else
    {
        $rector->setStatus('I');    
    }

    if ($status === 'update')
    {
        $rector->setId($_GET["id"]);
        
        if (RectorManager::updateRector($rector))
        {
            echo "OK";        
        }
        else
        {
            echo "KO";
        }
    }
    else if ($status === 'insert')
    {
        if (RectorManager::addRector($rector))
        {
            echo "OK";
        }
        else
        {
            echo "KO";
        }
    }

 ?>
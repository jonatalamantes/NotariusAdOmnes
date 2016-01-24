<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/DefuntionManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");

    if (!isset($_POST) || $_POST["idChild"] === NULL)
    {
        echo "KO";
        die;
    }

    $church  = ChurchManager::getSingleChurch('name', $_POST["celebrationChurch"]);
    
    $child = new Person();

    if ($_POST["idChild"] !== '0')
    {
        $child = PersonManager::getSinglePerson('id', $_POST["idChild"]);
    }

    $child->setId($_POST["idChild"]);
    $child->setNames($_POST["nameChild"]);
    $child->setLastname1($_POST["lastname1Child"]);
    $child->setLastname2($_POST["lastname2Child"]);

    $defuntion = new Defuntion();
    $defuntion->setId($_POST["idDefuntion"]);
    $defuntion->setDeadDate(DatabaseManager::singleDateToDatabaseDate($_POST["celebrationDate"]));
    $defuntion->setIdChurch($church->getId());

    $defuntion->setIdOwner($child->getId());

    //Get the defuntion Crypt
    if ($_POST["idCrypt"] == '0')
    {
        if ($_POST["inCrypt"] == "true")
        {
            $myCrypt = new Crypt();

            $myCrypt->setIdNiche($church->getIdNiche());
            $myCrypt->setCol($_POST["cryptColumn"]);
            $myCrypt->setRow($_POST["cryptRow"]);
            $myCrypt->setNumber($_POST["cryptNumber"]);

            DefuntionManager::addCrypt($myCrypt);

            $singleCrypt = DefuntionManager::getSingleCrypt('col', $myCrypt->getCol(), 
                                                            'row', $myCrypt->getRow(), 
                                                            'idNiche', $myCrypt->getIdNiche(), 
                                                            'number', $myCrypt->getNumber());

            $defuntion->setIdCrypt($singleCrypt->getId());
        }
        else
        {
            $defuntion->setIdCrypt(NULL);   
        }
    }
    else //Update data
    {
        if ($_POST["inCrypt"] == "true")
        {
            $myCrypt = DefuntionManager::getSingleCrypt('id', $_POST["idCrypt"]);

            $myCrypt->setIdNiche($church->getIdNiche());
            $myCrypt->setCol($_POST["cryptColumn"]);
            $myCrypt->setRow($_POST["cryptRow"]);
            $myCrypt->setNumber($_POST["cryptNumber"]);

            DefuntionManager::updateCrypt($myCrypt->getId(), $myCrypt);

            $defuntion->setIdCrypt($myCrypt->getId());
        }
        else
        {
            $defuntion->setIdCrypt(NULL);   
        }
    }

    //Add the registry
    if ($_SESSION["user_type"] != 'A') //is G
    {
        if ($_SESSION["user_church"] == $church->getId())
        {
            if ($_POST["status"] === 'insert')
            {
                if (DefuntionManager::addDefuntion($defuntion))
                {
                    echo "OK";
                }
                else
                {
                    echo "KO";
                }
            }
            else if ($_POST["status"] === 'update')
            {
                DefuntionManager::updateDefuntion($defuntion);
                echo "OK";
            }
        }
        else
        {
            echo "KO";
        }
    }
    else
    {
        if ($_POST["status"] === 'insert')
        {
            if (DefuntionManager::addDefuntion($defuntion))
            {
                echo "OK";
            }
            else
            {
                echo "KO";
            }
        }
        else if ($_POST["status"] === 'update')
        {
            DefuntionManager::updateDefuntion($defuntion);
            echo "OK";
        }
    }
 ?>
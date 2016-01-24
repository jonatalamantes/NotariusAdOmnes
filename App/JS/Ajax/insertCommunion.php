<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/CommunionManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");

    if (!isset($_POST))
    {
        echo "KO";
        die;
    }

    $church  = ChurchManager::getSingleChurch('name', $_POST["celebrationChurch"]);
    
    $child = new Person();

    if ($_POST["idChild"] !== '0' && $_POST["idChild"] !== '')
    {
        $child = PersonManager::getSinglePerson('id', $_POST["idChild"]);
    }

    $child->setId($_POST["idChild"]);
    $child->setNames($_POST["nameChild"]);
    $child->setLastname1($_POST["lastname1Child"]);
    $child->setLastname2($_POST["lastname2Child"]);

    $communion = new Communion();
    $communion->setId($_POST["idCommunion"]);
    $celb = DatabaseManager::singleDateToDatabaseDate($_POST["celebrationDate"]);
    $communion->setCelebrationDate($celb);
    $communion->setIdChurch($church->getId());
    $communion->setIdRector($_POST["rectorId"]);

    //Data Process for the Father
    $father = new Person();

    if ($_POST["idFather"] !== '0' && $_POST["idFather"] !== '')
    {
        $father = PersonManager::getSinglePerson('id', $_POST["idFather"]);

        $father->setId($_POST["idFather"]);
        $father->setNames($_POST["nameFather"]);
        $father->setLastname1($_POST["lastname1Father"]);
        $father->setLastname2($_POST["lastname2Father"]);
        $father->setGender('M');

        PersonManager::updatePerson($father);
    }
    else //No Father in the System New Data for all
    {
        if ($_POST["nameFather"] !== '')
        {
            $father = New Person();

            $father->setId(0);
            $father->setNames($_POST["nameFather"]);
            $father->setLastname1($_POST["lastname1Father"]);
            $father->setLastname2($_POST["lastname2Father"]);
            $father->setGender('M');

            $father->getIdMother(0);
            $father->getIdFather(0);

            PersonManager::addPerson($father, 'true');
            $father = PersonManager::getSinglePerson('id', PersonManager::getLastID());
        }
    }

    //Data Process for the mother
    $mother = new Person();

    if ($_POST["idMother"] !== '0' && $_POST["idMother"] !== '')
    {
        $mother = PersonManager::getSinglePerson('id', $_POST["idMother"]);

        $mother->setId($_POST["idMother"]);
        $mother->setNames($_POST["nameMother"]);
        $mother->setLastname1($_POST["lastname1Mother"]);
        $mother->setLastname2($_POST["lastname2Mother"]);
        $mother->setGender('F');

        PersonManager::updatePerson($mother);
    }
    else //No Father in the System New Data for all
    {
        if ($_POST["nameMother"] !== '')
        {
            $mother = New Person();

            $mother->setId(0);
            $mother->setNames($_POST["nameMother"]);
            $mother->setLastname1($_POST["lastname1Mother"]);
            $mother->setLastname2($_POST["lastname2Mother"]);
            $mother->setGender('F');

            PersonManager::addPerson($mother, 'true');
            $mother = PersonManager::getSinglePerson('id', PersonManager::getLastID());
        }
    }

    //Process The Child
    $child->setIdFather($father->getId());
    $child->setIdMother($mother->getId());

    if ($child->getId() === '0')
    {
        PersonManager::addPerson($child, 'true');
        $child = PersonManager::getSinglePerson('id', PersonManager::getLastID());
    }
    else
    {
        PersonManager::updatePerson($child);
    }

    $communion->setIdOwner($child->getId());

    //Process The GodFather
    if ($_POST["nameGodFather"] !== '')
    {
        $godFather = PersonManager::getSinglePerson('names',   $_POST["nameGodFather"],
                                                   'lastname1', $_POST["lastname1GodFather"],
                                                   'lastname2', $_POST["lastname2GodFather"]);

        if ($godFather === NULL) //No Godfather Found
        {
            $godFather = new Person();
            $godFather->setNames($_POST["nameGodFather"]);
            $godFather->setLastname1($_POST["lastname1GodFather"]);
            $godFather->setLastname2($_POST["lastname2GodFather"]);
            $godFather->setGender('M');

            PersonManager::addPerson($godFather, 'true');
            $godFather = PersonManager::getSinglePerson('id', PersonManager::getLastID());
        }

        $communion->setIdGodFather($godFather->getId());
    }
    
    //Get The Book Registry Data
    $reverse = substr($_POST["reverseBookRegistry"], 0, 1);

    if ($reverse === 'Y' || $reverse === 'S')
    {
        $reverse = 'Y';
    }

    $bookRegistry = CommunionManager::getSingleCommunionRegistry('book', $_POST["bookBookRegistry"], 
                                                             'page', $_POST["pageBookRegistry"], 
                                                             'number', $_POST["numBookRegistry"], 
                                                             'reverse', $reverse);

    if ($bookRegistry === NULL)
    {
        $bookRegistry = new CommunionRegistry();

        $bookRegistry->setBook($_POST["bookBookRegistry"]);
        $bookRegistry->setPage($_POST["pageBookRegistry"]);
        $bookRegistry->setNumber($_POST["numBookRegistry"]);
        $bookRegistry->setReverse($reverse);

        CommunionManager::addCommunionRegistry($bookRegistry);

        $bookRegistry = CommunionManager::getSingleCommunionRegistry(
                                                                 'book', $_POST["bookBookRegistry"], 
                                                                 'page', $_POST["pageBookRegistry"], 
                                                                 'number',$_POST["numBookRegistry"], 
                                                                 'reverse', substr($reverse, 0, 1));
    }

    $communion->setIdBookRegistry(1);

    if ($bookRegistry !== NULL)
    {
        $communion->setIdBookRegistry($bookRegistry->getId());
    }

    //Add the registry
    if ($_SESSION["user_type"] != 'A') //is G
    {
        if ($_SESSION["user_church"] == $church->getId())
        {
            if ($_POST["status"] === 'insert')
            {
                if (CommunionManager::addCommunion($communion))
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
                CommunionManager::updateCommunion($communion);
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
            if (CommunionManager::addCommunion($communion))
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
            CommunionManager::updateCommunion($communion);
            echo "OK";
        }
    }


 ?>
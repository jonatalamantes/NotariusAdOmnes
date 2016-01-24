<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");

    if (!isset($_POST) || $_POST["idBoyfriend"] == NULL)
    {
        echo "KO";
        die;
    }

    $churchMarriage  = ChurchManager::getSingleChurch('name', $_POST["celebrationChurch"]);
    $churchProcess   = ChurchManager::getSingleChurch('name', $_POST["processChurch"]);
    
    $boyfriend = new Person();

    if ($_POST["idBoyfriend"] !== '0')
    {
        $boyfriend = PersonManager::getSinglePerson('id', $_POST["idBoyfriend"]);
    }

    $girlfriend = new Person();

    if ($_POST["idGirlfriend"] !== '0')
    {
        $girlfriend = PersonManager::getSinglePerson('id', $_POST["idGirlfriend"]);
    }

    $boyfriend->setId($_POST["idBoyfriend"]);
    $boyfriend->setNames($_POST["boyfriendName"]);
    $boyfriend->setLastname1($_POST["lastname1Boyfriend"]);
    $boyfriend->setLastname2($_POST["lastname2Boyfriend"]);

    $girlfriend->setId($_POST["idGirlfriend"]);
    $girlfriend->setNames($_POST["girlfriendName"]);
    $girlfriend->setLastname1($_POST["lastname1Girlfriend"]);
    $girlfriend->setLastname2($_POST["lastname2Girlfriend"]);

    $marriage = new Marriage();
    $marriage->setId($_POST["idMarriage"]);
    $celb = DatabaseManager::singleDateToDatabaseDate($_POST["celebrationDate"]);
    $marriage->setCelebrationDate($celb);
    $marriage->setIdChurchProcess($churchProcess->getId());
    $marriage->setIdChurchMarriage($churchMarriage->getId());
    $marriage->setIdRector($_POST["rectorId"]);

    if ($boyfriend->getId() === '0')
    {
        PersonManager::addPerson($boyfriend, 'true');
        $boyfriend = PersonManager::getSinglePerson('id', PersonManager::getLastID());
    }
    else
    {
        PersonManager::updatePerson($boyfriend);
    }

    if ($girlfriend->getId() === '0')
    {
        PersonManager::addPerson($girlfriend, 'true');
        $girlfriend = PersonManager::getSinglePerson('id', PersonManager::getLastID());
    }
    else
    {
        PersonManager::updatePerson($girlfriend);
    }

    $marriage->setIdBoyfriend($boyfriend->getId());
    $marriage->setIdGirlfriend($girlfriend->getId());

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

        $marriage->setIdGodFather($godFather->getId());
    }

    //Process The GodMother
    if ($_POST["nameGodMother"] !== '')
    {
        $godMother = PersonManager::getSinglePerson('names',   $_POST["nameGodMother"],
                                                   'lastname1', $_POST["lastname1GodMother"],
                                                   'lastname2', $_POST["lastname2GodMother"]);

        if ($godMother === NULL) //No Godfather Found
        {
            $godMother = new Person();
            $godMother->setNames($_POST["nameGodMother"]);
            $godMother->setLastname1($_POST["lastname1GodMother"]);
            $godMother->setLastname2($_POST["lastname2GodMother"]);
            $godMother->setGender('F');

            PersonManager::addPerson($godMother, 'true');
            $godMother = PersonManager::getSinglePerson('id', PersonManager::getLastID());
        }

        $marriage->setIdGodMother($godMother->getId());
    }
    
    //Process The Witness1
    if ($_POST["nameWitness1"] !== '')
    {
        $witness1 = PersonManager::getSinglePerson('names',   $_POST["nameWitness1"],
                                                   'lastname1', $_POST["lastname1Witness1"],
                                                   'lastname2', $_POST["lastname2Witness1"]);

        if ($witness1 === NULL) //No Godfather Found
        {
            $witness1 = new Person();
            $witness1->setNames($_POST["nameWitness1"]);
            $witness1->setLastname1($_POST["lastname1Witness1"]);
            $witness1->setLastname2($_POST["lastname2Witness1"]);

            PersonManager::addPerson($witness1, 'true');
            $witness1 = PersonManager::getSinglePerson('id', PersonManager::getLastID());
        }

        $marriage->setIdWitness1($witness1->getId());
    }

    //Process The Witness1
    if ($_POST["nameWitness2"] !== '')
    {
        $witness2 = PersonManager::getSinglePerson('names',   $_POST["nameWitness2"],
                                                   'lastname1', $_POST["lastname1Witness2"],
                                                   'lastname2', $_POST["lastname2Witness2"]);

        if ($witness2 === NULL) //No Godfather Found
        {
            $witness2 = new Person();
            $witness2->setNames($_POST["nameWitness2"]);
            $witness2->setLastname1($_POST["lastname1Witness2"]);
            $witness2->setLastname2($_POST["lastname2Witness2"]);

            PersonManager::addPerson($witness2, 'true');
            $witness2 = PersonManager::getSinglePerson('id', PersonManager::getLastID());
        }

        $marriage->setIdWitness2($witness2->getId());
    }

    //Get The Book Registry Data
    $reverse = substr($_POST["reverseBookRegistry"], 0, 1);

    if ($reverse === 'Y' || $reverse === 'S')
    {
        $reverse = 'Y';
    }

    $bookRegistry = MarriageManager::getSingleMarriageRegistry('book', $_POST["bookBookRegistry"], 
                                                             'page', $_POST["pageBookRegistry"], 
                                                             'number', $_POST["numBookRegistry"], 
                                                             'reverse', $reverse);

    if ($bookRegistry === NULL)
    {
        $bookRegistry = new MarriageRegistry();

        $bookRegistry->setBook($_POST["bookBookRegistry"]);
        $bookRegistry->setPage($_POST["pageBookRegistry"]);
        $bookRegistry->setNumber($_POST["numBookRegistry"]);
        $bookRegistry->setReverse($reverse);

        MarriageManager::addMarriageRegistry($bookRegistry);

        $bookRegistry = MarriageManager::getSingleMarriageRegistry('book',$_POST["bookBookRegistry"], 
                                                                 'page', $_POST["pageBookRegistry"], 
                                                                 'number', $_POST["numBookRegistry"], 
                                                                 'reverse', substr($reverse, 0, 1));
    }

    $marriage->setIdBookRegistry(1);

    if ($bookRegistry !== NULL)
    {
        $marriage->setIdBookRegistry($bookRegistry->getId());
    }

    //Add the registry
    if ($_SESSION["user_type"] != 'A') //is G
    {
        if ($_SESSION["user_church"] == $church->getId())
        {
            if ($_POST["status"] === 'insert')
            {
                if (MarriageManager::addMarriage($marriage))
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
                MarriageManager::updateMarriage($marriage);
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
            if (MarriageManager::addMarriage($marriage))
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
            MarriageManager::updateMarriage($marriage);
            echo "OK";
        }
    }
 ?>
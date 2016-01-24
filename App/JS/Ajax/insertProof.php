<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/ProofManager.php");
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
    $child->setAddress($_POST["addressChild"]);
    $child->setPhoneNumber($_POST["phoneChild"]);
    $child->setIdCityAddress(CityManager::getSingleCity('name', $_POST["cityChild"])->getId());

    $proof = new ProofTalks();
    $proof->setId($_POST["idProof"]);
    $proof->setIdChurch($church->getId());

    $typeProof = "B";

    if ($_POST["type"] === '1')
    {
        $typeProof = "E";
    }
    else if ($_POST["type"] === '2')
    {
        $typeProof = "C";
    }
    else if ($_POST["type"] === '3')
    {
        $typeProof = "X";
    }
    
    $proof->setType($typeProof);

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

    $proof->setIdOwner($child->getId());

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

        $proof->setIdGodFather($godFather->getId());
    }
    else
    {
        $proof->setIdGodFather(NULL);   
    }

    //Process The GodFather
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

        $proof->setIdGodMother($godMother->getId());
    }
    else
    {
        $proof->setIdGodMother(NULL);
    }

    //Add the registry
    if ($_SESSION["user_type"] != 'A') //is G
    {
        if ($_SESSION["user_church"] == $church->getId())
        {
            if ($_POST["status"] === 'insert')
            {
                if (ProofManager::addProofTalks($proof))
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
                ProofManager::updateProofTalks($proof);
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
            if (ProofManager::addProofTalks($proof))
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
            ProofManager::updateProofTalks($proof);
            echo "OK";
        }
    }
 ?>
<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/BaptismManager.php");
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
    $child->setGender(substr($_POST["genderChild"], 0, 1));

    $baptism = new Baptism();
    $baptism->setId($_POST["idBaptism"]);
    $celb = DatabaseManager::singleDateToDatabaseDate($_POST["celebrationDate"]);
    $baptism->setCelebrationDate($celb);
    $baptism->setBornDate(DatabaseManager::singleDateToDatabaseDate($_POST["bornDateChild"]));
    $baptism->setBornPlace($_POST["bornPlaceChild"]);
    $baptism->setIdChurch($church->getId());
    $baptism->setIdRector($_POST["rectorId"]);

    $legitimate = substr($_POST["legitimateChild"], 0, 1);
    if ($legitimate === 'S' || $legitimate === 'Y')
    {
        $baptism->setLegitimate('Y');
    }
    else
    {
        $baptism->setLegitimate('N');
    }

    //Data Process for the Father
    $father = new Person();

    if ($_POST["idFather"] !== '0')
    {
        $father = PersonManager::getSinglePerson('id', $_POST["idFather"]);

        $father->setId($_POST["idFather"]);
        $father->setNames($_POST["nameFather"]);
        $father->setLastname1($_POST["lastname1Father"]);
        $father->setLastname2($_POST["lastname2Father"]);
        $father->setGender('M');

        $grandFatherF = PersonManager::getSinglePerson('id', $father->getIdFather());

        if ($grandFatherF === NULL) //No exist GrandFather
        {
            if ($_POST["nameFatherF"] !== '') //New Data For GrandFather
            {
                $grandFatherF = new Person();
                $grandFatherF->setId(0);
                $grandFatherF->setNames($_POST["nameFatherF"]);
                $grandFatherF->setLastname1($_POST["lastname1FatherF"]);
                $grandFatherF->setLastname2($_POST["lastname2FatherF"]);
                $grandFatherF->setGender('M');

                PersonManager::addPerson($grandFatherF, 'true');
                $grandFatherF = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else
            {
                $grandFatherF = new Person();
                $grandFatherF->setId('NULL');
            }
        }
        else
        {
            $grandFatherF->setId($father->getIdFather());
            $grandFatherF->setNames($_POST["nameFatherF"]);
            $grandFatherF->setLastname1($_POST["lastname1FatherF"]);
            $grandFatherF->setLastname2($_POST["lastname2FatherF"]);
            $grandFatherF->setGender('M');

            PersonManager::updatePerson($grandFatherF);
        }

        $grandMotherF = PersonManager::getSinglePerson('id', $father->getIdMother());

        if ($grandMotherF === NULL) //No exist GrandFather
        {
            if ($_POST["nameFatherM"] !== '') //New Data For GrandFather
            {
                $grandMotherF = new Person();
                $grandMotherF->setId(0);
                $grandMotherF->setNames($_POST["nameFatherM"]);
                $grandMotherF->setLastname1($_POST["lastname1FatherM"]);
                $grandMotherF->setLastname2($_POST["lastname2FatherM"]);
                $grandMotherF->setGender('F');

                PersonManager::addPerson($grandMotherF, 'true');
                $grandMotherF = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else
            {
                $grandMotherF = new Person();
                $grandMotherF->setId('NULL');
            }
        }
        else
        {
            $grandMotherF->setId($father->getIdMother());
            $grandMotherF->setNames($_POST["nameFatherM"]);
            $grandMotherF->setLastname1($_POST["lastname1FatherM"]);
            $grandMotherF->setLastname2($_POST["lastname2FatherM"]);
            $grandMotherF->setGender('F');

            PersonManager::updatePerson($grandMotherF);
        }

        $father->getIdMother($grandMotherF->getId());
        $father->getIdFather($grandFatherF->getId());

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

            if ($_POST["nameFatherF"] !== '') //New Data For GrandFather
            {
                $grandFatherF = new Person();
                $grandFatherF->setId(0);
                $grandFatherF->setNames($_POST["nameFatherF"]);
                $grandFatherF->setLastname1($_POST["lastname1FatherF"]);
                $grandFatherF->setLastname2($_POST["lastname2FatherF"]);
                $grandFatherF->setGender('M');

                PersonManager::addPerson($grandFatherF, 'true');
                $grandFatherF = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else //No GrandFather
            {
                $grandFatherF = new Person();
                $grandFatherF->setId('NULL');
            }
        
            if ($_POST["nameFatherM"] !== '') //New Data For GrandFather
            {
                $grandMotherF = new Person();
                $grandMotherF->setId(0);
                $grandMotherF->setNames($_POST["nameFatherM"]);
                $grandMotherF->setLastname1($_POST["lastname1FatherM"]);
                $grandMotherF->setLastname2($_POST["lastname2FatherM"]);
                $grandMotherF->setGender('F');

                PersonManager::addPerson($grandMotherF, 'true');
                $grandMotherF = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else
            {
                $grandMotherF = new Person();
                $grandMotherF->setId('NULL');
            }

            $father->getIdMother($grandMotherF->getId());
            $father->getIdFather($grandFatherF->getId());

            PersonManager::addPerson($father, 'true');
            $father = PersonManager::getSinglePerson('id', PersonManager::getLastID());
        }
    }

    //Data Process for the mother
    $mother = new Person();

    if ($_POST["idMother"] !== '0')
    {
        $mother = PersonManager::getSinglePerson('id', $_POST["idMother"]);

        $mother->setId($_POST["idMother"]);
        $mother->setNames($_POST["nameMother"]);
        $mother->setLastname1($_POST["lastname1Mother"]);
        $mother->setLastname2($_POST["lastname2Mother"]);
        $mother->setGender('F');

        $grandFatherM = PersonManager::getSinglePerson('id', $mother->getIdFather());

        if ($grandFatherM === NULL) //No exist GrandFather
        {
            if ($_POST["nameMotherF"] !== '') //New Data For GrandFather
            {
                $grandFatherM = new Person();
                $grandFatherM->setId(0);
                $grandFatherM->setNames($_POST["nameMotherF"]);
                $grandFatherM->setLastname1($_POST["lastname1MotherF"]);
                $grandFatherM->setLastname2($_POST["lastname2MotherF"]);
                $grandFatherM->setGender('M');

                PersonManager::addPerson($grandFatherM);
                $grandFatherM = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else
            {
                $grandFatherM = new Person();
                $grandFatherM->setId('NULL');
            }
        }
        else
        {
            $grandFatherM->setId($mother->getIdFather());
            $grandFatherM->setNames($_POST["nameMotherF"]);
            $grandFatherM->setLastname1($_POST["lastname1MotherF"]);
            $grandFatherM->setLastname2($_POST["lastname2MotherF"]);
            $grandFatherM->setGender('M');

            PersonManager::updatePerson($grandFatherM);
        }

        $grandMotherM = PersonManager::getSinglePerson('id', $mother->getIdMother());

        if ($grandMotherM === NULL) //No exist GrandFather
        {
            if ($_POST["nameMotherM"] !== '') //New Data For GrandFather
            {
                $grandMotherM = new Person();
                $grandMotherM->setId(0);
                $grandMotherM->setNames($_POST["nameMotherM"]);
                $grandMotherM->setLastname1($_POST["lastname1MotherM"]);
                $grandMotherM->setLastname2($_POST["lastname2MotherM"]);
                $grandMotherM->setGender('F');

                PersonManager::addPerson($grandMotherM, 'true');
                $grandMotherM = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else
            {
                $grandMotherM = new Person();
                $grandMotherM->setId('NULL');
            }
        }
        else
        {
            $grandMotherM->setId($mother->getIdMother());
            $grandMotherM->setNames($_POST["nameMotherM"]);
            $grandMotherM->setLastname1($_POST["lastname1MotherM"]);
            $grandMotherM->setLastname2($_POST["lastname2MotherM"]);
            $grandMotherM->setGender('F');

            PersonManager::updatePerson($grandMotherM);
        }

        $mother->getIdMother($grandMotherM->getId());
        $mother->getIdFather($grandFatherM->getId());

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

            if ($_POST["nameMotherF"] !== '') //New Data For GrandFather
            {
                $grandFatherM = new Person();
                $grandFatherM->setId(0);
                $grandFatherM->setNames($_POST["nameMotherF"]);
                $grandFatherM->setLastname1($_POST["lastname1MotherF"]);
                $grandFatherM->setLastname2($_POST["lastname2MotherF"]);
                $grandFatherM->setGender('M');

                PersonManager::addPerson($grandFatherM, 'true');
                $grandFatherM = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else //No GrandFather
            {
                $grandFatherM = new Person();
                $grandFatherM->setId('NULL');
            }
        
            if ($_POST["nameMotherM"] !== '') //New Data For GrandFather
            {
                $grandMotherM = new Person();
                $grandMotherM->setId(0);
                $grandMotherM->setNames($_POST["nameMotherM"]);
                $grandMotherM->setLastname1($_POST["lastname1MotherM"]);
                $grandMotherM->setLastname2($_POST["lastname2MotherM"]);
                $grandMotherM->setGender('F');

                PersonManager::addPerson($grandMotherM, 'true');
                $grandMotherM = PersonManager::getSinglePerson('id', PersonManager::getLastID());
            }
            else
            {
                $grandMotherM = new Person();
                $grandMotherM->setId('NULL');
            }

            $mother->getIdMother($grandMotherM->getId());
            $mother->getIdFather($grandFatherM->getId());

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

    $baptism->setIdOwner($child->getId());

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

        $baptism->setIdGodFather($godFather->getId());
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

        $baptism->setIdGodMother($godMother->getId());
    }
    
    //Get The Book Registry Data
    $reverse = substr($_POST["reverseBookRegistry"], 0, 1);

    if ($reverse === 'Y' || $reverse === 'S')
    {
        $reverse = 'Y';
    }

    $bookRegistry = BaptismManager::getSingleBaptismRegistry('book', $_POST["bookBookRegistry"], 
                                                             'page', $_POST["pageBookRegistry"], 
                                                             'number', $_POST["numBookRegistry"], 
                                                             'reverse', $reverse);

    if ($bookRegistry === NULL)
    {
        $bookRegistry = new BaptismRegistry();

        $bookRegistry->setBook($_POST["bookBookRegistry"]);
        $bookRegistry->setPage($_POST["pageBookRegistry"]);
        $bookRegistry->setNumber($_POST["numBookRegistry"]);
        $bookRegistry->setReverse($reverse);

        BaptismManager::addBaptismRegistry($bookRegistry);

        $bookRegistry = BaptismManager::getSingleBaptismRegistry('book', $_POST["bookBookRegistry"], 
                                                                 'page', $_POST["pageBookRegistry"], 
                                                                 'number',$_POST["numBookRegistry"], 
                                                                 'reverse', substr($reverse, 0, 1));
    }

    $baptism->setIdBookRegistry(1);

    if ($bookRegistry !== NULL)
    {
        $baptism->setIdBookRegistry($bookRegistry->getId());
    }

    //Get The Civil Registry Data
    $officeTemp = $_POST["officeCivilRegistry"];
    $posComa    = strpos($officeTemp, ',');

    $numberOffice   = substr($officeTemp, 4, $posComa-4);
    $cityOfficeName = substr($officeTemp, $posComa+2, -1);

    $cityId = CityManager::getSingleCity('name', $cityOfficeName)->getId();
    $office = BaptismManager::getSingleOfficeCivilRegistry('number', $numberOffice, 
                                                           'idCity', $cityId);

    $civilRegistry = BaptismManager::getSingleCivilRegistry('book', $_POST["bookCivilRegistry"], 
                                                            'page', $_POST["pageCivilRegistry"], 
                                                            'number', $_POST["numCivilRegistry"], 
                                                        'idOfficineCivilRegistry',$office->getId());
    if ($civilRegistry === NULL)
    {
        $civilRegistry = new civilRegistry();

        $civilRegistry->setBook($_POST["bookCivilRegistry"]);
        $civilRegistry->setPage($_POST["pageCivilRegistry"]);
        $civilRegistry->setNumber($_POST["numCivilRegistry"]);
        $civilRegistry->setIdOffice($office->getId());

        BaptismManager::addCivilRegistry($civilRegistry);

        $civilRegistry = BaptismManager::getSingleCivilRegistry('book', $_POST["bookCivilRegistry"], 
                                                                'page', $_POST["pageCivilRegistry"], 
                                                                'number', $_POST["numCivilRegistry"], 
                                                        'idOfficineCivilRegistry', $office->getId());
    }

    $baptism->setIdCivilRegistry(1);

    if ($civilRegistry !== NULL)
    {
        $baptism->setIdCivilRegistry($civilRegistry->getId());
    }

    //Add the registry
    if ($_SESSION["user_type"] != 'A') //is G
    {
        if ($_SESSION["user_church"] == $church->getId())
        {
            if ($_POST["status"] === 'insert')
            {
                if (BaptismManager::addBaptism($baptism))
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
                BaptismManager::updateBaptism($baptism);
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
            if (BaptismManager::addBaptism($baptism))
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
            BaptismManager::updateBaptism($baptism);
            echo "OK";
        }
    }

 ?>
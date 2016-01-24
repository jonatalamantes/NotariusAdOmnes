<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../../Backend/ConfirmationManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");
    require_once(__DIR__."/../../../Backend/BaptismManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");

    if (!isset($_POST) || $_POST["idChild"] === NULL)
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

    $confirmation = new Confirmation();
    $confirmation->setId($_POST["idConfirmation"]);
    $celb = DatabaseManager::singleDateToDatabaseDate($_POST["celebrationDate"]);
    $confirmation->setCelebrationDate($celb);
    $confirmation->setIdChurch($church->getId());
    $confirmation->setIdRector($_POST["rectorId"]);

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

    $confirmation->setIdOwner($child->getId());

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

        $confirmation->setIdGodFather($godFather->getId());
    }
    
    //Get The Book Registry Data
    $reverse = substr($_POST["reverseBookRegistry"], 0, 1);

    if ($reverse === 'Y' || $reverse === 'S')
    {
        $reverse = 'Y';
    }

    $bookRegistry = ConfirmationManager::getSingleConfirmationRegistry(
                                                             'book', $_POST["bookBookRegistry"], 
                                                             'page', $_POST["pageBookRegistry"], 
                                                             'number', $_POST["numBookRegistry"], 
                                                             'reverse', $reverse);

    if ($bookRegistry === NULL)
    {
        $bookRegistry = new ConfirmationRegistry();

        $bookRegistry->setBook($_POST["bookBookRegistry"]);
        $bookRegistry->setPage($_POST["pageBookRegistry"]);
        $bookRegistry->setNumber($_POST["numBookRegistry"]);
        $bookRegistry->setReverse($reverse);

        ConfirmationManager::addConfirmationRegistry($bookRegistry);

        $bookRegistry = ConfirmationManager::getSingleConfirmationRegistry( 
                                                                 'book', $_POST["bookBookRegistry"], 
                                                                 'page', $_POST["pageBookRegistry"], 
                                                                 'number',$_POST["numBookRegistry"], 
                                                                 'reverse', substr($reverse, 0, 1));
    }

    $confirmation->setIdBookRegistry(1);

    if ($bookRegistry !== NULL)
    {
        $confirmation->setIdBookRegistry($bookRegistry->getId());
    }

    //Add the registry
    if ($_SESSION["user_type"] != 'A') //is G
    {
        if ($_SESSION["user_church"] == $church->getId())
        {
            if ($_POST["status"] === 'insert')
            {
                if (ConfirmationManager::addConfirmation($confirmation))
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
                ConfirmationManager::updateConfirmation($confirmation);
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
            if (ConfirmationManager::addConfirmation($confirmation))
            {
                echo "OK";
                
                if ($_POST["baptismId"] === '0') //Alredy Not Baptism
                {        
                    if ($_POST["baptismChurch"] != "XXXXXXXXXX")
                    {
                        $bookRegistry = new BaptismRegistry();
            
                        $bookRegistry->setBook($_POST["bookBookRegistryB"]);
                        $bookRegistry->setPage($_POST["pageBookRegistryB"]);
                        $bookRegistry->setNumber($_POST["numBookRegistryB"]);
                
                        BaptismManager::addBaptismRegistry($bookRegistry);
                
                        $bookRegistry = BaptismManager::getSingleBaptismRegistry( 
                                                                                 'book', $_POST["bookBookRegistryB"], 
                                                                                 'page', $_POST["pageBookRegistryB"], 
                                                                                 'number',$_POST["numBookRegistryB"]);
                                                                                             
                        $baptism = new Baptism('0', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL');
                        $baptism->setIdCivilRegistry('1');
                        
                        $celb = DatabaseManager::singleDateToDatabaseDate($_POST["baptismDate"]);
                        $baptism->setCelebrationDate($celb);
                        
                        $church  = ChurchManager::getSingleChurch('name', $_POST["baptismChurch"]);
                        
                        if ($church !== NULL)
                        {
                            $baptism->setIdChurch($church->getId());    
                            $baptism->setIdRector(RectorManager::getSingleRector('idActualChurch', $church->getId())->getId());
                        }
                        
                        $baptism->setIdOwner($child->getId());
                        $baptism->setIdBookRegistry($bookRegistry->getId());
                        
                        BaptismManager::addBaptism($baptism);
                    }        
                }
                else 
                {    
                    $baptism = BaptismManager::getSingleBaptism('id', $_POST["baptismId"]);
                    
                    if ($baptism !== NULL)
                    {
                        $celb = DatabaseManager::singleDateToDatabaseDate($_POST["baptismDate"]);
                        $baptism->setCelebrationDate($celb);
                        
                        $church  = ChurchManager::getSingleChurch('name', $_POST["baptismChurch"]);
                        
                        if ($church !== NULL)
                        {
                            $baptism->setIdChurch($church->getId());    
                        }
                        
                        BaptismManager::updateBaptism($baptism);
            
                        $baptismReg = BaptismManager::getSingleBaptismRegistry('id', $baptism->getIdBookRegistry());
                        
                        $baptismReg->setBook($_POST["bookBookRegistryB"]);
                        $baptismReg->setPage($_POST["pageBookRegistryB"]);
                        $baptismReg->setNumber($_POST["numBookRegistryB"]);
                                    
                        BaptismManager::updateBaptismRegistry($baptismReg);
                    }
                }
            }
            else
            {
                echo "KO";
            }
        }
        else if ($_POST["status"] === 'update')
        {
            ConfirmationManager::updateConfirmation($confirmation);
            echo "OK";
            
            if ($_POST["baptismId"] === '0') //Alredy Baptism
            {        
                if ($_POST["baptismChurch"] != "XXXXXXXXXX")
                {
                    $bookRegistry = new BaptismRegistry();
        
                    $bookRegistry->setBook($_POST["bookBookRegistryB"]);
                    $bookRegistry->setPage($_POST["pageBookRegistryB"]);
                    $bookRegistry->setNumber($_POST["numBookRegistryB"]);
            
                    BaptismManager::addBaptismRegistry($bookRegistry);
            
                    $bookRegistry = BaptismManager::getSingleBaptismRegistry( 
                                                                             'book', $_POST["bookBookRegistryB"], 
                                                                             'page', $_POST["pageBookRegistryB"], 
                                                                             'number',$_POST["numBookRegistryB"]);
                                                                                         
                    $baptism = new Baptism('0', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL');
                    $baptism->setIdCivilRegistry('1');
                    
                    $celb = DatabaseManager::singleDateToDatabaseDate($_POST["baptismDate"]);
                    $baptism->setCelebrationDate($celb);
                    
                    $church  = ChurchManager::getSingleChurch('name', $_POST["baptismChurch"]);
                    
                    if ($church !== NULL)
                    {
                        $baptism->setIdChurch($church->getId());    
                        $baptism->setIdRector(RectorManager::getSingleRector('idActualChurch', $church->getId())->getId());
                    }
                    
                    $baptism->setIdOwner($child->getId());
                    $baptism->setIdBookRegistry($bookRegistry->getId());
                    
                    BaptismManager::addBaptism($baptism);
                }        
            }
            else 
            {    
                $baptism = BaptismManager::getSingleBaptism('id', $_POST["baptismId"]);
                
                if ($baptism !== NULL)
                {
                    $celb = DatabaseManager::singleDateToDatabaseDate($_POST["baptismDate"]);
                    $baptism->setCelebrationDate($celb);
                    
                    $church  = ChurchManager::getSingleChurch('name', $_POST["baptismChurch"]);
                    
                    if ($church !== NULL)
                    {
                        $baptism->setIdChurch($church->getId());    
                    }
                    
                    BaptismManager::updateBaptism($baptism);
        
                    $baptismReg = BaptismManager::getSingleBaptismRegistry('id', $baptism->getIdBookRegistry());
                    
                    $baptismReg->setBook($_POST["bookBookRegistryB"]);
                    $baptismReg->setPage($_POST["pageBookRegistryB"]);
                    $baptismReg->setNumber($_POST["numBookRegistryB"]);
                                
                    BaptismManager::updateBaptismRegistry($baptismReg);
                }
            }
        }
    }


 ?>
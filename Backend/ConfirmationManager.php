<?php 
    
    require_once("Confirmation.php");
    require_once("CityManager.php");
    require_once("ChurchManager.php");
    require_once("ChangesLogsManager.php");
    require_once("PersonManager.php");

    /**
    * Class for manipulate Confirmation Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ConfirmationManager
    {
        /**
         * Transform one Confirmation object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Confirmation $confirmation    confirmation object to Transform
         * @return  Array        $confirmation    array result for transformation or null
         */
        static function ConfirmationToArray($confirmation = null)
        {
            if ($confirmation === null)
            {
                return null;
            }
            else
            {
                $confirmationArray = array();

                $confirmationArray['id']                     = $confirmation->getId();
                $confirmationArray['confirmationDate']       = $confirmation->getCelebrationDate();
                $confirmationArray['idOwner']                = $confirmation->getIdOwner();
                $confirmationArray['idGodFather']            = $confirmation->getIdGodFather();
                $confirmationArray['idConfirmationRegistry'] = $confirmation->getIdBookRegistry();
                $confirmationArray['idChurch']               = $confirmation->getIdChurch();
                $confirmationArray['idRector']               = $confirmation->getIdRector();

                return $confirmationArray;
            }
        }

        /**
         * Transform one Array object into a Confirmation Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array         $confirmation        Array object to transform
         * @return  Confirmation  $confirmation        Confirmation result or null
         */
        static function ArrayToConfirmation($confirmationArray = array())
        {
            if ($confirmationArray === null)
            {
                return null;
            }

            $confirmation = new Confirmation($confirmationArray['id'], 
                                             $confirmationArray['confirmationDate'], 
                                             $confirmationArray['idOwner'], 
                                             $confirmationArray['idGodFather'], 
                                             $confirmationArray['idConfirmationRegistry'], 
                                             $confirmationArray['idChurch'], 
                                             $confirmationArray['idRector']);

            return $confirmation;
        }

        /**
         * Transform one ConfirmationRegistry object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   ConfirmationRegistry $confirmationRegistry ConfirmationRegistry object 
         * @return  Array                $array                Array result or null
         */
        static function ConfirmationRegistryToArray($confirmationRegistry = null)
        {
            if ($confirmationRegistry === null)
            {
                return null;
            }

            $array = array();

            $array['id']      = $confirmationRegistry->getId();
            $array['book']    = $confirmationRegistry->getBook();
            $array['number']  = $confirmationRegistry->getNumber();
            $array['page']    = $confirmationRegistry->getPage();
            $array['reverse'] = $confirmationRegistry->getReverse();

            return $array;
        }

        /**
         * Transform one Array object into a ConfirmationRegistry Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array                $array                Array object to transform
         * @return  ConfirmationRegistry $confirmationRegistry ConfirmationRegistry result or null
         */
        static function ArrayToConfirmationRegistry($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $confirmationRegistry = new ConfirmationRegistry($array['id'], 
                                                             $array['book'], 
                                                             $array['number'], 
                                                             $array['page'], 
                                                             $array['reverse']);
            return $confirmationRegistry;
        }

        /**
         * Return if two confirmation objects are equals
         * 
         * @param  Confirmation     $confirmation1 Confirmation 1
         * @param  Confirmation     $confirmation2 Confirmation 2
         * @return boolean         result
         */
        static function compareConfirmation($confirmation1 = null, $confirmation2 = null)
        {
            if ($confirmation1 === null || $confirmation2 === null)
            {
                return false;
            }
            else
            {
                if (($confirmation1->getIdOwner()         == $confirmation2->getIdOwner())   &&
                    ($confirmation1->getCelebrationDate() == $confirmation2->getCelebrationDate()))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        /**
         * Return if two confirmationRegistry objects are equals
         * 
         * @param  ConfirmationRegistry     $confirmaReg1   ConfirmationRegistry 1
         * @param  ConfirmationRegistry     $confirmaReg2   ConfirmationRegistry 2
         * @return boolean             result
         */
        static function compareConfirmationRegistry($confirmaReg1 = null, $confirmaReg2 = null)
        {
            if ($confirmaReg1 === null || $confirmaReg2 === null)
            {
                return false;
            }
            else
            {
                if (($confirmaReg1->getBook()    == $confirmaReg2->getBook())    &&
                    ($confirmaReg1->getNumber()  == $confirmaReg2->getNumber())  &&
                    ($confirmaReg1->getReverse() == $confirmaReg2->getReverse()) &&
                    ($confirmaReg1->getPage()    == $confirmaReg2->getPage()))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        /**
         * Recover from database one ConfirmationRegistry object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $key                 Key to search
         * @param  string            $value               Value of the key
         * @param  string            $key2                Other Key to search
         * @param  string            $value2              Other Value of the key
         * @param  string            $key3                Other Key to search
         * @param  string            $value3              Other Value of the key
         * @param  string            $key4                Other Key to search
         * @param  string            $value4              Other Value of the key
         * @return ConfirmationRegistry  $myConfirmationRegistry confirmationRegistry result or null
         */
        static function getSingleConfirmationRegistry($key = 'id', $value = '', 
                                                      $key2 = '', $value2 = '', 
                                                      $key3 = '', $value3 = '', 
                                                      $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $TableConfirmationReg=DatabaseManager::getNameTable('TABLE_CONFIRMATION_REGISTRY');

            $query      = "SELECT $TableConfirmationReg.*
                           FROM $TableConfirmationReg 
                           WHERE $TableConfirmationReg.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $TableConfirmationReg.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $TableConfirmationReg.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $TableConfirmationReg.$key4 = '$value4'";
            }

            $myConfirmationRegistry    = DatabaseManager::singleFetchAssoc($query);
            $myConfirmationRegistry    = self::ArrayToConfirmationRegistry($myConfirmationRegistry);

            return $myConfirmationRegistry;
        }

        /**
         * Recover from database one Confirmation object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $key           key to search
         * @param  string            $value         value of the key
         * @param  string            $key2          Other Key to search
         * @param  string            $value2        Other Value of the key
         * @return Confirmation  $confirmation      Confirmation result or null
         */
        static function getSingleConfirmation($key = 'id', $value = '', $key2 = '', $value2 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableConfirmation  = DatabaseManager::getNameTable('TABLE_CONFIRMATION');

            $query     = "SELECT $tableConfirmation.*
                           FROM $tableConfirmation 
                           WHERE $tableConfirmation.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableConfirmation.$key2 = '$value2'";
            }

            $confirmation      = DatabaseManager::singleFetchAssoc($query);
            $confirmation      = self::ArrayToConfirmation($confirmation);

            return $confirmation;
        }

/**
         * Recover all Confirmation from the database begin in one part of the confirmation table
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $order       The type of sort of the Confirmation
         * @param  integer           $begin       The number of page to display the registry
         * @return Array[Confirmation]    $confirmations    Array of Confirmation Object
         */
        static function getAllConfirmations($order = 'id', $begin = 0)
        {
            $tableConfirmation  = DatabaseManager::getNameTable('TABLE_CONFIRMATION');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableConfirmation.* 
                          FROM $tableConfirmation JOIN $tablePerson
                         ON $tableConfirmation.idOwner = $tablePerson.id 
                         JOIN $tableChurch 
                         ON $tableConfirmation.idChurch = $tableChurch.id";

            if ($order == 'nameChild')
            {
                $query = $query . " ORDER BY $tablePerson.lastname1";
            }
            else if ($order == 'nameChurch')
            {
                $query = $query . " ORDER BY $tableChurch.name";
            }
            else
            {
                $query = $query . " ORDER BY $tableConfirmation.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayConfirmations = DatabaseManager::multiFetchAssoc($query);
            $confirmations      = array();

            if ($arrayConfirmations !== NULL)
            {
                $i = 0;
                foreach ($arrayConfirmations as $confirmation) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $confirmations[] = self::ArrayToConfirmation($confirmation);
                    $i++;
                }

                return $confirmations;
            }
            else
            {
                return null;
            }
        }

        /**
         * Recover all ConfirmationRegistry from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[ConfirmationRegistry] $confirmationRegistries Array of ConfirmationRegistry 
         */
        static function getAllConfirmationRegistries()
        {
            $TableConfirmationReg=DatabaseManager::getNameTable('TABLE_CONFIRMATION_REGISTRY');

            $query     = "SELECT $TableConfirmationReg.*
                           FROM $TableConfirmationReg
                           ORDER BY book";

            $arrayConfirmationRegistries = DatabaseManager::multiFetchAssoc($query);
            $confirmationRegistries      = array();

            foreach ($arrayConfirmationRegistries as $confirmationRegistry) 
            {
                $confirmationRegistries[] =self::ArrayToConfirmationRegistry($confirmationRegistry);
            }

            return $confirmationRegistries;
        }

        /**
         * insert one confirmation in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Confirmation $confirmation  The confirmation to insert
         * @return boolean           If was possible to insert
         */
        static function addConfirmation($confirmation = null)
        {
            if ($confirmation === null)
            {
                return false;
            }

            $idOwner         = $confirmation->getIdOwner();
            $celebrationDate = $confirmation->getCelebrationDate();
            $singleConfirmation = self::getSingleConfirmation('idOwner',          $idOwner, 
                                                              'confirmationDate', $celebrationDate);

            if (self::compareConfirmation($singleConfirmation, $confirmation) === false)
            {
                $tableConfirmation = DatabaseManager::getNameTable('TABLE_CONFIRMATION');

                $idGodFather     = $confirmation->getIdGodFather();
                $idBookRegistry  = $confirmation->getIdBookRegistry();
                $idChurch        = $confirmation->getIdChurch();
                $idRector        = $confirmation->getIdRector();

                $query     = "INSERT INTO Confirmation 
                             (confirmationDate,       idOwner,  idGodFather, 
                              idConfirmationRegistry, idChurch, idRector) 
                             VALUES 
                             ('$celebrationDate', '$idOwner',  '$idGodFather', 
                              '$idBookRegistry',  '$idChurch', '$idRector')";

                $person = PersonManager::getSinglePerson("id", $idOwner);
                ChangesLogsManager::addChangesLogs("I", "Confirmacion de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Confirmation Exist
            {
                return false;
            }
        }

        /**
         * insert one confirmationRegistry in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  ConfirmationRegistry $confirmationRegistry  The confirmationRegistry to insert
         * @return boolean       If was possible to insert
         */
        static function addConfirmationRegistry($confirmationRegistry = null)
        {
            if ($confirmationRegistry === null)
            {
                return false;
            }

            $number  = $confirmationRegistry->getNumber();
            $book    = $confirmationRegistry->getBook();
            $page    = $confirmationRegistry->getPage();
            $reverse = $confirmationRegistry->getReverse();

            $singleConfirmationRegistry = self::getSingleConfirmationRegistry('number', $number, 
                                                                              'book', $book, 
                                                                              'page', $page, 
                                                                              'reverse', $reverse);

            if ($singleConfirmationRegistry === null)
            {
                $TableConfirmationReg =DatabaseManager::getNameTable('TABLE_CONFIRMATION_REGISTRY');

                $query     = "INSERT INTO $TableConfirmationReg
                              (number, book, page, reverse)
                              VALUES 
                              ('$number', '$book', '$page', '$reverse')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //ConfirmationRegistry exist
            {
                return false;
            }
        }

        /**
         * delete one confirmation from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Confirmation $confirmation  The confirmation to delete
         * @return boolean     if was possible to delete
         */
        static function removeConfirmation($confirmation = null)
        {
            if ($confirmation === null)
            {
                return false;
            }
            else
            {
                $tableConfirmation  = DatabaseManager::getNameTable('TABLE_CONFIRMATION');
                $id         = $confirmation->getId();

                $query     = "DELETE FROM $tableConfirmation
                              WHERE $tableConfirmation.id = $id";

                $person = PersonManager::getSinglePerson("id", $confirmation->getIdOwner());
                ChangesLogsManager::addChangesLogs("D", "Eliminacion de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * update one confirmation in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Confirmation $confirmation  The confirmation to update
         * @return boolean     if was possible to update
         */
        static function updateConfirmation($confirmation = null)
        {
            if ($confirmation === null)
            {
                return false;
            }

            $tableConfirmation = DatabaseManager::getNameTable('TABLE_CONFIRMATION');

            $id              = $confirmation->getId();
            $celebrationDate = $confirmation->getCelebrationDate();
            $idGodFather     = $confirmation->getIdGodFather();
            $idBookRegistry  = $confirmation->getIdBookRegistry();
            $idChurch        = $confirmation->getIdChurch();
            $idRector        = $confirmation->getIdRector();
            $idOwner         = $confirmation->getIdOwner();

            $query     = "UPDATE $tableConfirmation
                          SET confirmationDate       = '$celebrationDate', 
                              idOwner                = '$idOwner', 
                              idGodFather            = '$idGodFather', 
                              idConfirmationRegistry = '$idBookRegistry', 
                              idChurch               = '$idChurch', 
                              idRector               = '$idRector' 
                          WHERE $tableConfirmation.id = $id";

            $person = PersonManager::getSinglePerson("id", $idOwner);
            ChangesLogsManager::addChangesLogs("C", "Confirmacion de " . $person->getFullNameBeginName());

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * search one confirmation by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $names      name of the person to search
         * @param  string         $lastname1  lastname1 of the person to search
         * @param  string         $lastname2  lastname2 of the person to search
         * @param  string         $operator   operator to seach like 'AND' or 'OR'
         * @return Array[Confirmation] $confirmations  Confirmation with the similar name or null
         */
        static function simpleSearchByNames($names     = '', $lastname1 = '', 
                                            $lastname2 = '', $operator = 'OR')
        {
            if ($names === '')
            {
                return null;
            }

            $lastname1 === '' ? $lastnameA = $names : $lastnameA = $lastname1;
            $lastname2 === '' ? $lastnameB = $names : $lastnameB = $lastname2;

            $tableConfirmation = DatabaseManager::getNameTable('TABLE_CONFIRMATION');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableConfirmation.* 
                          FROM $tableConfirmation JOIN $tablePerson 
                          ON $tableConfirmation.idOwner = $tablePerson.id
                          WHERE $tablePerson.names     = '$names'     $operator
                                $tablePerson.lastname1 = '$lastnameA' $operator
                                $tablePerson.lastname2 = '$lastnameB'";

            $arrayConfirmations = DatabaseManager::multiFetchAssoc($query);

            if ($arrayConfirmations === null)
            {
                return null;
            }
            else
            {
                $confirmations      = array();

                foreach ($arrayConfirmations as $confirmation) 
                {
                    $confirmations[] = self::ArrayToConfirmation($confirmation);
                }

                return $confirmations;
            }
        }

        /**
         * Search one confirmation by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $string       Necesary string to search
         * @param  string         $order        The type of sort of the Confirmation
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Confirmation] $confirmations     Confirmation with the similar name or null
         */
        static function simpleSearchConfirmation($string = '', $order = "id", $begin = 0)
        {
            $tableConfirmation  = DatabaseManager::getNameTable('TABLE_CONFIRMATION');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableConfirmation.* 
                          FROM $tableConfirmation JOIN $tablePerson
                          ON $tableConfirmation.idOwner = $tablePerson.id 
                          JOIN $tableChurch 
                          ON $tableConfirmation.idChurch = $tableChurch.id
                          WHERE $tablePerson.names     LIKE '%$string%' OR
                                $tablePerson.lastname1 LIKE '%$string%' OR
                                $tablePerson.lastname2 LIKE '%$string%' OR
                                $tableChurch.name      LIKE '%$string%' OR
                                $tableConfirmation.id       LIKE '%$string%'";

            if ($order == 'nameChild')
            {
                $query = $query . " ORDER BY $tablePerson.lastname1";
            }
            else if ($order == 'nameChurch')
            {
                $query = $query . " ORDER BY $tableChurch.name";
            }
            else
            {
                $query = $query . " ORDER BY $tableConfirmation.id";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayConfirmations = DatabaseManager::multiFetchAssoc($query);
            $confirmations      = array();

            if ($arrayConfirmations === NULL)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayConfirmations as $confirmation) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $confirmations[] = self::ArrayToConfirmation($confirmation);
                    $i++;
                }

                return $confirmations;
            }
        }

        /**
         * Search one confirmation by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Confirmation   $confirmation Pseudo-confirmation with the data to search
         * @param  string         $operator     To search with 'or' or 'and'
         * @param  string         $order        The type of sort of the Confirmation
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Confirmation] $confirmations  Confirmation  with the similar name or null
         */
        static function advancedSearchConfirmation($confirmation = null, $operator = 'AND', 
                                                   $order = 'id',        $begin = 0)
        {
            if ($confirmation === null)
            {
                return null;
            }

            $tableConfirmation = DatabaseManager::getNameTable('TABLE_CONFIRMATION');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $celebrationDate = $confirmation->getCelebrationDate();
            $queryOwner      = "(";
            $posibleOwner    = $confirmation->getIdOwner()[0];
            $queryFather     = "(";
            $posibleFather   = $confirmation->getIdOwner()[1];
            $queryMother     = "(";
            $posibleMother   = $confirmation->getIdOwner()[2];
            $queryChurch     = "(";
            $posibleChurch   = $confirmation->getIdChurch();

            if ($posibleOwner !== NULL) //If exist owner id
            {
                for ($i = 0; $i < sizeof($posibleOwner) - 1; $i++)
                {
                    $queryOwner = $queryOwner . $posibleOwner[$i]->getId() . ",";
                }

                $queryOwner  = $queryOwner . $posibleOwner[sizeof($posibleOwner)-1]->getId(). ")";
                $queryOwner  = "(o.id IN " . $queryOwner . ")";
            }

            if ($posibleFather !== NULL) //If exist father id
            {
                for ($i = 0; $i < sizeof($posibleFather) - 1; $i++)
                {
                    $queryFather = $queryFather . $posibleFather[$i]->getId() . ",";
                }
    
                $queryFather  = $queryFather.$posibleFather[sizeof($posibleFather)-1]->getId(). ")";
                $queryFather  = "((fa.id IN " . $queryFather . ") OR fa.id IS NULL)";
            }

            if ($posibleMother !== NULL) //If exist mother id
            {
                for ($i = 0; $i < sizeof($posibleMother) - 1; $i++)
                {
                    $queryMother = $queryMother . $posibleMother[$i]->getId() . ",";
                }

                $queryMother  = $queryMother.$posibleMother[sizeof($posibleMother)-1]->getId(). ")";
                $queryMother  = "((mo.id IN " . $queryMother . ") OR mo.id IS NULL)";
            }

            if ($posibleChurch !== NULL) //If exist church
            {
                for ($i = 0; $i < sizeof($posibleChurch) - 1; $i++)
                {
                    $queryChurch = $queryChurch . $posibleChurch[$i]->getId() . ",";
                }

                $queryChurch  = $queryChurch.$posibleChurch[sizeof($posibleChurch)-1]->getId(). ")";
                $queryChurch  = "(c.id IN " . $queryChurch . ")";
            }

            if ($confirmation->getId() == 0)
            {
               $id = ''; 
            }
            else
            {
                $id = $confirmation->getId();
            }

            if ($confirmation->getIdBookRegistry() == 0)
            {
                $idBookRegistry  = '';
            }
            else
            {
                 $idBookRegistry = $confirmation->getIdBookRegistry()->getId();
            }

            $query =   "SELECT b.* 
                        FROM $tableConfirmation AS b LEFT JOIN $tablePerson AS o ON b.idOwner = o.id 
                        LEFT JOIN $tablePerson AS fa ON o.idFather = fa.id
                        LEFT JOIN $tablePerson AS mo ON o.idMother = mo.id
                        JOIN $tableChurch AS c  ON b.idChurch = c.id
                        WHERE b.id               LIKE '%$id%'               $operator
                              b.confirmationDate      LIKE '%$celebrationDate%'  $operator ";

            //Join the Query with the posibiitation query
            if ($queryOwner != '(')
            {
                $query = $query . $queryOwner . " " . $operator. " ";
            }
            else
            {
                $query = $query . "(o.id IN ())" . $operator. " ";
            }

            if ($queryFather != '(')
            {
                $query = $query . $queryFather . " " . $operator. " ";
            }
            else
            {
                $query = $query . "(fa.id IN ())" . $operator. " ";
            }

            if ($queryMother != '(')
            {
                $query = $query . $queryMother . " " . $operator. " ";
            }
            else
            {
                $query = $query . "(mo.id IN ())" . $operator. " ";
            }

            if ($queryChurch != '(')
            {
                $query = $query . $queryChurch . " ". $operator . " ";
            }
            else
            {
                $query = $query . "(c.id IN ())" . $operator. " ";
            }

            if ($idBookRegistry !== NULL)
            {
                $query = $query . "b.idConfirmationRegistry LIKE '%$idBookRegistry%'";   
            }
            else
            {
                $query = $query . "b.idConfirmationRegistry LIKE '%%'";
            }

            if ($order == 'nameChild')
            {
                $query = $query . " ORDER BY o.names";
            }
            else if ($order == 'nameChurch')
            {
                $query = $query . " ORDER BY c.name";
            }
            else
            {
                $query = $query . " ORDER BY b.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayConfirmations = DatabaseManager::multiFetchAssoc($query);
            $confirmations      = array();

            if ($arrayConfirmations !== NULL)
            {
                $i = 0;
                foreach ($arrayConfirmations as $confirmation) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $confirmations[] = self::ArrayToConfirmation($confirmation);
                    $i++;
                }

                return $confirmations;
            }
            else
            {
                return null;
            }
        }
    }

 ?>
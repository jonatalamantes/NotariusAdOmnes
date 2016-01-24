<?php 
    
    require_once("Communion.php");
    require_once("CityManager.php");
    require_once("ChurchManager.php");
    require_once("PersonManager.php");
    require_once("ChangesLogsManager.php");

    /**
    * Class for manipulate Communion Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CommunionManager
    {
        /**
         * Transform one Communion object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Communion $communion    communion object to Transform
         * @return  Array     $communion    array result for transformation or null
         */
        static function CommunionToArray($communion = null)
        {
            if ($communion === null)
            {
                return null;
            }
            else
            {
                $communionArray = array();

                $communionArray['id']                   = $communion->getId();
                $communionArray['communionDate']        = $communion->getCelebrationDate();
                $communionArray['idOwner']              = $communion->getIdOwner();
                $communionArray['idGodFather']          = $communion->getIdGodFather();
                $communionArray['idCommunionRegistry']  = $communion->getIdBookRegistry();
                $communionArray['idChurch']             = $communion->getIdChurch();
                $communionArray['idRector']             = $communion->getIdRector();

                return $communionArray;
            }
        }

        /**
         * Transform one Array object into a Communion Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array      $communion   Array object to transform
         * @return  Communion  $communion   Communion result or null
         */
        static function ArrayToCommunion($communionArray = array())
        {
            if ($communionArray === null)
            {
                return null;
            }

            $communion = new Communion($communionArray['id'],      
                                       $communionArray['communionDate'], 
                                       $communionArray['idOwner'], 
                                       $communionArray['idGodFather'], 
                                       $communionArray['idCommunionRegistry'], 
                                       $communionArray['idChurch'], 
                                       $communionArray['idRector']);

            return $communion;
        }

        /**
         * Transform one CommunionRegistry object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   CommunionRegistry    $communionRegistry  CommunionRegistry object to transform
         * @return  Array                $array              Array result or null
         */
        static function CommunionRegistryToArray($communionRegistry = null)
        {
            if ($communionRegistry === null)
            {
                return null;
            }

            $array = array();

            $array['id']      = $communionRegistry->getId();
            $array['book']    = $communionRegistry->getBook();
            $array['number']  = $communionRegistry->getNumber();
            $array['page']    = $communionRegistry->getPage();
            $array['reverse'] = $communionRegistry->getReverse();

            return $array;
        }

        /**
         * Transform one Array object into a CommunionRegistry Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array    $array      Array object to transform
         * @return  CommunionRegistry    $communionRegistry      CommunionRegistry result or null
         */
        static function ArrayToCommunionRegistry($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $communionRegistry = new CommunionRegistry($array['id'], 
                                                       $array['book'], 
                                                       $array['number'], 
                                                       $array['page'], 
                                                       $array['reverse']);
            
            return $communionRegistry;
        }

        /**
         * Return if two communion objects are equals
         * 
         * @param  Communion     $communion1 Communion 1
         * @param  Communion     $communion2 Communion 2
         * @return boolean         result
         */
        static function compareCommunion($communion1 = null, $communion2 = null)
        {
            if ($communion1 === null || $communion2 === null)
            {
                return false;
            }
            else
            {
                if (($communion1->getIdOwner()         == $communion2->getIdOwner())   &&
                    ($communion1->getCelebrationDate() == $communion2->getCelebrationDate()))
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
         * Return if two communionRegistry objects are equals
         * 
         * @param  CommunionRegistry     $communionReg1   CommunionRegistry 1
         * @param  CommunionRegistry     $communionReg2   CommunionRegistry 2
         * @return boolean             result
         */
        static function compareCommunionRegistry($communionReg1 = null, $communionReg2 = null)
        {
            if ($communionReg1 === null || $communionReg2 === null)
            {
                return false;
            }
            else
            {
                if (($communionReg1->getBook()    == $communionReg2->getBook())    &&
                    ($communionReg1->getNumber()  == $communionReg2->getNumber())  &&
                    ($communionReg1->getReverse() == $communionReg2->getReverse()) &&
                    ($communionReg1->getPage()    == $communionReg2->getPage()))
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
         * Recover from database one CommunionRegistry object
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
         * @return CommunionRegistry   $myCommunionRegistry   communionRegistry result or null
         */
        static function getSingleCommunionRegistry($key = 'id', $value = '', 
                                                   $key2 = '', $value2 = '', 
                                                   $key3 = '', $value3 = '', 
                                                   $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableCommunionRegistry = DatabaseManager::getNameTable('TABLE_COMMUNION_REGISTRY');

            $query      = "SELECT $tableCommunionRegistry.*
                           FROM $tableCommunionRegistry 
                           WHERE $tableCommunionRegistry.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableCommunionRegistry.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tableCommunionRegistry.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $tableCommunionRegistry.$key4 = '$value4'";
            }

            $myCommunionRegistry    = DatabaseManager::singleFetchAssoc($query);
            $myCommunionRegistry    = self::ArrayToCommunionRegistry($myCommunionRegistry);

            return $myCommunionRegistry;
        }

        /**
         * Recover from database one Communion object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string     $key            key to search
         * @param  string     $value          value of the key
         * @param  string     $key2           Other Key to search
         * @param  string     $value2         Other Value of the key
         * @return Communion  $communion      Communion result or null
         */
        static function getSingleCommunion($key = 'id', $value = '', $key2 = '', $value2 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableCommunion  = DatabaseManager::getNameTable('TABLE_COMMUNION');

            $query     = "SELECT $tableCommunion.*
                           FROM $tableCommunion 
                           WHERE $tableCommunion.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableCommunion.$key2 = '$value2'";
            }

            $communion      = DatabaseManager::singleFetchAssoc($query);
            $communion      = self::ArrayToCommunion($communion);

            return $communion;
        }

        /**
         * Recover all Communion from the database begin in one part of the communion table
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $order       The type of sort of the Communion
         * @param  integer           $begin       The number of page to display the registry
         * @return Array[Communion]    $communions    Array of Communion Object
         */
        static function getAllCommunions($order = 'id', $begin = 0)
        {
            $tableCommunion  = DatabaseManager::getNameTable('TABLE_COMMUNION');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableCommunion.* 
                          FROM $tableCommunion JOIN $tablePerson
                           ON $tableCommunion.idOwner = $tablePerson.id 
                           JOIN $tableChurch 
                           ON $tableCommunion.idChurch = $tableChurch.id";

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
                $query = $query . " ORDER BY $tableCommunion.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayCommunions = DatabaseManager::multiFetchAssoc($query);
            $communions      = array();

            if ($arrayCommunions !== NULL)
            {
                $i = 0;
                foreach ($arrayCommunions as $communion) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $communions[] = self::ArrayToCommunion($communion);
                    $i++;
                }

                return $communions;
            }
            else
            {
                return null;
            }
        }

        /**
         * Recover all CommunionRegistry from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[CommunionRegistry]     $communionRegistries     Array of Object
         */
        static function getAllCommunionRegistries()
        {
            $tableCommunionRegistry  = DatabaseManager::getNameTable('TABLE_COMMUNION_REGISTRY');

            $query     = "SELECT $tableCommunionRegistry.*
                           FROM $tableCommunionRegistry
                           ORDER BY book";

            $arrayCommunionRegistries = DatabaseManager::multiFetchAssoc($query);
            $communionRegistries      = array();

            foreach ($arrayCommunionRegistries as $communionRegistry) 
            {
                $communionRegistries[] = self::ArrayToCommunionRegistry($communionRegistry);
            }

            return $communionRegistries;
        }

        /**
         * insert one communion in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Communion $communion  The communion to insert
         * @return boolean           If was possible to insert
         */
        static function addCommunion($communion = null)
        {
            if ($communion === null)
            {
                return false;
            }

            $idOwner         = $communion->getIdOwner();
            $celebrationDate = $communion->getCelebrationDate();
            $singleCommunion = self::getSingleCommunion('idOwner',       $idOwner, 
                                                        'communionDate', $celebrationDate);

            if (self::compareCommunion($singleCommunion, $communion) === false)
            {
                $tableCommunion = DatabaseManager::getNameTable('TABLE_COMMUNION');

                $idGodFather     = $communion->getIdGodFather();
                $idBookRegistry  = $communion->getIdBookRegistry();
                $idChurch        = $communion->getIdChurch();
                $idRector        = $communion->getIdRector();

                $query     = "INSERT INTO Communion 
                             (communionDate,       idOwner,  idGodFather, 
                              idCommunionRegistry, idChurch, idRector) 
                             VALUES 
                             ('$celebrationDate', '$idOwner',  '$idGodFather', 
                              '$idBookRegistry',  '$idChurch', '$idRector')";

                $person = PersonManager::getSinglePerson("id", $idOwner);
                ChangesLogsManager::addChangesLogs("I", "Comunion de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Communion Exist
            {
                return false;
            }
        }

        /**
         * insert one communionRegistry in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  CommunionRegistry $communionRegistry  The communionRegistry to insert
         * @return boolean       If was possible to insert
         */
        static function addCommunionRegistry($communionRegistry = null)
        {
            if ($communionRegistry === null)
            {
                return false;
            }

            $number  = $communionRegistry->getNumber();
            $book    = $communionRegistry->getBook();
            $page    = $communionRegistry->getPage();
            $reverse = $communionRegistry->getReverse();

            $singleCommunionRegistry = self::getSingleCommunionRegistry('number',  $number, 
                                                                        'book',    $book, 
                                                                        'page',    $page, 
                                                                        'reverse', $reverse);

            if ($singleCommunionRegistry === null)
            {
                $tableCommunionRegistry = DatabaseManager::getNameTable('TABLE_COMMUNION_REGISTRY');

                $query     = "INSERT INTO $tableCommunionRegistry
                              (number, book, page, reverse)
                              VALUES 
                              ('$number', '$book', '$page', '$reverse')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //CommunionRegistry exist
            {
                return false;
            }
        }

        /**
         * delete one communion from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Communion $communion  The communion to delete
         * @return boolean     if was possible to delete
         */
        static function removeCommunion($communion = null)
        {
            if ($communion === null)
            {
                return false;
            }
            else
            {
                $tableCommunion  = DatabaseManager::getNameTable('TABLE_COMMUNION');
                $id         = $communion->getId();

                $query     = "DELETE FROM $tableCommunion
                              WHERE $tableCommunion.id = $id";

                $person = PersonManager::getSinglePerson("id", $communion->getIdOwner());
                ChangesLogsManager::addChangesLogs("D", "Comunion de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * update one communion in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Communion $communion  The communion to update
         * @return boolean     if was possible to update
         */
        static function updateCommunion($communion = null)
        {
            if ($communion === null)
            {
                return false;
            }

            $tableCommunion = DatabaseManager::getNameTable('TABLE_COMMUNION');

            $id              = $communion->getId();
            $celebrationDate = $communion->getCelebrationDate();
            $idGodFather     = $communion->getIdGodFather();
            $idBookRegistry  = $communion->getIdBookRegistry();
            $idChurch        = $communion->getIdChurch();
            $idRector        = $communion->getIdRector();
            $idOwner         = $communion->getIdOwner();

            $query     = "UPDATE $tableCommunion
                          SET communionDate       = '$celebrationDate', 
                              idOwner             = '$idOwner', 
                              idGodFather         = '$idGodFather', 
                              idCommunionRegistry = '$idBookRegistry', 
                              idChurch            = '$idChurch', 
                              idRector            = '$idRector' 
                          WHERE $tableCommunion.id = $id";

            $person = PersonManager::getSinglePerson("id", $idOwner);
            ChangesLogsManager::addChangesLogs("D", "Comunion de " . $person->getFullNameBeginName());

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * search one communion by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $names      name of the person to search
         * @param  string         $lastname1  lastname1 of the person to search
         * @param  string         $lastname2  lastname2 of the person to search
         * @param  string         $operator   operator to seach like 'AND' or 'OR'
         * @return Array[Communion] $communions     Communion objects with the similar name or null
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

            $tableCommunion = DatabaseManager::getNameTable('TABLE_COMMUNION');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableCommunion.* 
                          FROM $tableCommunion JOIN $tablePerson 
                          ON $tableCommunion.idOwner = $tablePerson.id
                          WHERE $tablePerson.names     = '$names'     $operator
                                $tablePerson.lastname1 = '$lastnameA' $operator
                                $tablePerson.lastname2 = '$lastnameB'";

            $arrayCommunions = DatabaseManager::multiFetchAssoc($query);

            if ($arrayCommunions === null)
            {
                return null;
            }
            else
            {
                $communions      = array();

                foreach ($arrayCommunions as $communion) 
                {
                    $communions[] = self::ArrayToCommunion($communion);
                }

                return $communions;
            }
        }

        /**
         * Search one communion by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $string       Necesary string to search
         * @param  string         $order        The type of sort of the Communion
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Communion] $communions     Communion objects with the similar name or null
         */
        static function simpleSearchCommunion($string = '', $order = "id", $begin = 0)
        {
            $tableCommunion  = DatabaseManager::getNameTable('TABLE_COMMUNION');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableCommunion.* 
                          FROM $tableCommunion JOIN $tablePerson
                          ON $tableCommunion.idOwner = $tablePerson.id 
                          JOIN $tableChurch 
                          ON $tableCommunion.idChurch = $tableChurch.id
                          WHERE $tablePerson.names     LIKE '%$string%' OR
                                $tablePerson.lastname1 LIKE '%$string%' OR
                                $tablePerson.lastname2 LIKE '%$string%' OR
                                $tableChurch.name      LIKE '%$string%' OR
                                $tableCommunion.id     LIKE '%$string%'";

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
                $query = $query . " ORDER BY $tableCommunion.id";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayCommunions = DatabaseManager::multiFetchAssoc($query);
            $communions      = array();

            if ($arrayCommunions === NULL)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayCommunions as $communion) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $communions[] = self::ArrayToCommunion($communion);
                    $i++;
                }

                return $communions;
            }
        }

        /**
         * Search one communion by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Communion        $communion      Pseudo-communion with the data to search
         * @param  string         $operator     To search with 'or' or 'and'
         * @param  string         $order        The type of sort of the Communion
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Communion] $communions     Communion objects with the similar name or null
         */
        static function advancedSearchCommunion($communion = null, $operator = 'AND', 
                                                $order     = 'id', $begin = 0)
        {
            if ($communion === null)
            {
                return null;
            }

            $tableCommunion = DatabaseManager::getNameTable('TABLE_COMMUNION');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $celebrationDate = $communion->getCelebrationDate();
            $queryOwner      = "(";
            $posibleOwner    = $communion->getIdOwner()[0];
            $queryFather     = "(";
            $posibleFather   = $communion->getIdOwner()[1];
            $queryMother     = "(";
            $posibleMother   = $communion->getIdOwner()[2];
            $queryChurch     = "(";
            $posibleChurch   = $communion->getIdChurch();

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

            if ($communion->getId() == 0)
            {
                $id = '';
            }
            else
            {
                $id = $communion->getId();
            }

            if ($communion->getIdBookRegistry()  == 0)
            {
                $idBookRegistry = '';
            }
            else
            {
                $idBookRegistry = $communion->getIdBookRegistry()->getId();
            }

            $query =   "SELECT b.* 
                        FROM $tableCommunion AS b LEFT JOIN $tablePerson AS o ON b.idOwner = o.id 
                        LEFT JOIN $tablePerson AS fa ON o.idFather = fa.id
                        LEFT JOIN $tablePerson AS mo ON o.idMother = mo.id
                        JOIN $tableChurch AS c  ON b.idChurch = c.id
                        WHERE b.id               LIKE '%$id%'               $operator
                              b.CommunionDate    LIKE '%$celebrationDate%'  $operator ";

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
                $query = $query . "b.idCommunionRegistry LIKE '%$idBookRegistry%'";   
            }
            else
            {
                $query = $query . "b.idCommunionRegistry LIKE '%%'";
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

            $arrayCommunions = DatabaseManager::multiFetchAssoc($query);
            $communions      = array();

            if ($arrayCommunions !== NULL)
            {
                $i = 0;
                foreach ($arrayCommunions as $communion) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $communions[] = self::ArrayToCommunion($communion);
                    $i++;
                }

                return $communions;
            }
            else
            {
                return null;
            }
        }
    }

 ?>
<?php 
    
    require_once("Defuntion.php");
    require_once("DatabaseManager.php");
    require_once("CityManager.php");
    require_once("ChangesLogsManager.php");
    require_once("PersonManager.php");

    /**
    * Class for manipulate Defuntion Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class DefuntionManager
    {
        /**
         * Transform one Defuntion object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Defuntion  $defuntion       defuntion object to Transform
         * @return  Array      $defuntion       array result for transformation or null
         */
        static function DefuntionToArray($defuntion = null)
        {
            if ($defuntion === null)
            {
                return null;
            }
            else
            {
                $defuntion = array();

                $defuntion['id']          = $defuntion->getId();
                $defuntion['deadDate']    = $defuntion->getDeadDate();
                $defuntion['idOwner']     = $defuntion->getIdOwner();
                $defuntion['idChurch']    = $defuntion->getIdChurch();
                $defuntion['idCrypt']     = $defuntion->getIdCrypt();

                return $defuntion;
            }
        }

        /**
         * Transform one Array object into a Defuntion Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array      $defuntion         Array object to transform
         * @return  Defuntion  $defuntion2        Defuntion result or null
         */
        static function ArrayToDefuntion($defuntion = array())
        {
            if ($defuntion === null)
            {
                return null;
            }

            $defuntion2 = new Defuntion($defuntion['id'], 
                                        $defuntion['idOwner'], 
                                        $defuntion['deadDate'], 
                                        $defuntion['idCrypt'], 
                                        $defuntion['idChurch']);

            return $defuntion2;
        }

        /**
         * Transform one Crypt object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Crypt    $crypt      Crypt object to transform
         * @return  Array    $array      Array result or null
         */
        static function CryptToArray($crypt = null)
        {
            if ($crypt === null)
            {
                return null;
            }

            $array = array();

            $array['id']      = $crypt->getId();
            $array['col']     = $crypt->getRow();
            $array['row']     = $crypt->getCol();
            $array['number']  = $crypt->getNumber();
            $array['idNiche'] = $crypt->getIdNiche();

            return $array;
        }

        /**
         * Transform one Array object into a Crypt Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array    $array      Array object to transform
         * @return  Crypt    $crypt      Crypt result or null
         */
        static function ArrayToCrypt($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $crypt = new Crypt($array['id'],    $array['col'],     $array['row'], 
                              $array['number'], $array['idNiche']);
             
            return $crypt;
        }

        /**
         * Return if two defuntion objects are equals
         * 
         * @param  Defuntion     $defuntion1 Defuntion 1
         * @param  Defuntion     $defuntion2 Defuntion 2
         * @return boolean         result
         */
        static function compareDefuntion($defuntion1 = null, $defuntion2 = null)
        {
            if ($defuntion1 === null || $defuntion2 === null)
            {
                return false;
            }
            else
            {
                if (($defuntion1->getIdOwner()    == $defuntion2->getIdOwner()) &&
                    ($defuntion1->getDeadDate()   == $defuntion2->getDeadDate()))
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
         * Return if two crypt objects are equals
         * 
         * @param  Crypt     $crypt1   Crypt 1
         * @param  Crypt     $crypt2   Crypt 2
         * @return boolean             result
         */
        static function compareCrypt($crypt1 = null, $crypt2 = null)
        {
            if ($crypt1 === null || $crypt2 === null)
            {
                return false;
            }
            else
            {
                if (($crypt1->getCol()     == $crypt2->getCol()) &&
                    ($crypt1->getRow()     == $crypt2->getRow()) &&
                    ($crypt1->getNumber()  == $crypt2->getNumber()) &&
                    ($crypt1->getIdNiche() == $crypt2->getIdNiche()))
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
         * Recover from database one Crypt object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       Key to search
         * @param  string  $value     Value of the key
         * @param  string  $key2      Other Key to search
         * @param  string  $value2    Other Value of the key
         * @param  string  $key3      Other Key to search
         * @param  string  $value3    Other Value of the key
         * @param  string  $key4      Other Key to search
         * @param  string  $value4    Other Value of the key
         * @return Crypt   $myCrypt   crypt result or null
         */
        static function getSingleCrypt($key = 'id', $value = '', 
                                       $key2 = '', $value2 = '', 
                                       $key3 = '', $value3 = '', 
                                       $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableCrypt = DatabaseManager::getNameTable('TABLE_CRYPT');

            $query      = "SELECT $tableCrypt.*
                           FROM $tableCrypt 
                           WHERE $tableCrypt.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableCrypt.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tableCrypt.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $tableCrypt.$key4 = '$value4'";
            }

            $myCrypt    = DatabaseManager::singleFetchAssoc($query);
            $myCrypt    = self::ArrayToCrypt($myCrypt);

            return $myCrypt;
        }

        /**
         * Recover from database one Defuntion object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       key to search
         * @param  string  $value     value of the key
         * @return Defuntion  $defuntion      Defuntion result or null
         */
        static function getSingleDefuntion($key = 'id', $value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableDefuntion  = DatabaseManager::getNameTable('TABLE_DEFUNTION');

            $query     = "SELECT $tableDefuntion.*
                           FROM $tableDefuntion 
                           WHERE $tableDefuntion.$key = '$value'";

            $defuntion      = DatabaseManager::singleFetchAssoc($query);
            $defuntion      = self::ArrayToDefuntion($defuntion);

            return $defuntion;
        }

        /**
         * Recover all Defuntion from the database begin in one part of the defuntion table
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $order       The type of sort of the Defuntion
         * @param  integer           $begin       The number of page to display the registry
         * @return Array[Defuntion]    $defuntions    Array of Defuntion Object
         */
        static function getAllDefuntions($order = 'id', $begin = 0)
        {
            $tableDefuntion  = DatabaseManager::getNameTable('TABLE_DEFUNTION');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableDefuntion.* 
                          FROM $tableDefuntion JOIN $tablePerson
                             ON $tableDefuntion.idOwner = $tablePerson.id 
                             JOIN $tableChurch 
                             ON $tableDefuntion.idChurch = $tableChurch.id";

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
                $query = $query . " ORDER BY $tableDefuntion.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayDefuntions = DatabaseManager::multiFetchAssoc($query);
            $defuntions      = array();

            if ($arrayDefuntions !== NULL)
            {
                $i = 0;
                foreach ($arrayDefuntions as $defuntion) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $defuntions[] = self::ArrayToDefuntion($defuntion);
                    $i++;
                }

                return $defuntions;
            }
            else
            {
                return null;
            }
        }

        /**
         * Recover all Crypt from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[Crypt]     $crypts     Array of Crypt Object
         */
        static function getAllCrypts()
        {
            $tableCrypt  = DatabaseManager::getNameTable('TABLE_CRYPT');

            $query     = "SELECT $tableCrypt.*
                           FROM $tableCrypt
                           ORDER BY row";

            $arrayCrypts = DatabaseManager::multiFetchAssoc($query);
            $crypts      = array();

            foreach ($arrayCrypts as $crypt) 
            {
                $crypts[] = self::ArrayToCrypt($crypt);
            }

            return $crypts;
        }

        /**
         * insert one defuntion in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Defuntion $defuntion  The defuntion to insert
         * @return boolean     If was possible to insert
         */
        static function addDefuntion($defuntion = null)
        {
            if ($defuntion === null)
            {
                return false;
            }

            $idOwner = $defuntion->getIdOwner();

            $singleDefuntion = self::getSingleDefuntion('idOwner', $idOwner);

            if (self::compareDefuntion($singleDefuntion, $defuntion) === false)
            {
                $tableDefuntion = DatabaseManager::getNameTable('TABLE_DEFUNTION');

                $idChurch    = $defuntion->getIdChurch();
                $idCrypt     = $defuntion->getIdCrypt();
                $deadDate    = $defuntion->getDeadDate();

                if ($idCrypt == "")
                {
                    $idCrypt = "NULL";
                }

                $query     = "INSERT INTO Defuntion 
                             (deadDate, idOwner, idChurch, idCrypt) 
                             VALUES 
                             ('$deadDate', '$idOwner', '$idChurch', $idCrypt)";

                $person = PersonManager::getSinglePerson("id", $idOwner);
                ChangesLogsManager::addChangesLogs("I", "Defuncion de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Defuntion Exist
            {
                return false;
            }
        }

        /**
         * insert one crypt in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Crypt $crypt  The crypt to insert
         * @return boolean       If was possible to insert
         */
        static function addCrypt($crypt = null)
        {
            if ($crypt === null)
            {
                return false;
            }

            $col     = $crypt->getCol();
            $row     = $crypt->getRow();
            $idNiche = $crypt->getIdNiche();
            $number  = $crypt->getNumber();

            $singleCrypt = self::getSingleCrypt('col', $col, 
                                                'row', $row, 
                                                'idNiche', $idNiche, 
                                                'number', $number);

            if ($singleCrypt === null)
            {
                $tableCrypt = DatabaseManager::getNameTable('TABLE_CRYPT');

                $query     = "INSERT INTO $tableCrypt 
                              (col, row, idNiche, number)
                              VALUES 
                              ('$col', '$row', $idNiche, '$number')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Crypt exist
            {
                return false;
            }
        }

        /**
         * delete one defuntion from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Defuntion $defuntion  The defuntion to delete
         * @return boolean     if was possible to delete
         */
        static function removeDefuntion($defuntion = null)
        {
            if ($defuntion === null)
            {
                return false;
            }
            else
            {
                $tableDefuntion  = DatabaseManager::getNameTable('TABLE_DEFUNTION');
                $id         = $defuntion->getId();

                $query     = "DELETE FROM $tableDefuntion
                              WHERE $tableDefuntion.id = $id";

                $person = PersonManager::getSinglePerson("id", $defuntion->getIdOwner());
                ChangesLogsManager::addChangesLogs("D", "Defuncion de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * insert one crypt in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Crypt $crypt  The crypt to insert
         * @return boolean       If was possible to insert
         */
        static function updateCrypt($idCrypt = 0, $crypt = null)
        {
            if ($crypt === null || $idCrypt === 0)
            {
                return false;
            }

            $col     = $crypt->getCol();
            $row     = $crypt->getRow();
            $idNiche = $crypt->getIdNiche();
            $number  = $crypt->getNumber();

            $tableCrypt = DatabaseManager::getNameTable('TABLE_CRYPT');

            $query     = "UPDATE $tableCrypt 
                          SET col = '$col', row = '$row', idNiche = '$idNiche', number = '$number'
                          WHERE id = $idCrypt";

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * update one defuntion in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Defuntion $defuntion  The defuntion to update
         * @return boolean     if was possible to update
         */
        static function updateDefuntion($defuntion = null)
        {
            if ($defuntion === null)
            {
                return false;
            }

            $tableDefuntion = DatabaseManager::getNameTable('TABLE_DEFUNTION');

            $id          = $defuntion->getId();
            $deadDate    = $defuntion->getDeadDate();
            $idOwner     = $defuntion->getIdOwner();
            $idChurch    = $defuntion->getIdChurch();
            $idCrypt     = $defuntion->getIdCrypt();

            if ($idCrypt == "")
            {
                $idCrypt = "NULL";
            }

            $query     = "UPDATE $tableDefuntion
                          SET deadDate = '$deadDate', idOwner = '$idOwner', idChurch = '$idChurch', 
                              idCrypt = $idCrypt 
                          WHERE $tableDefuntion.id = $id";

            $person = PersonManager::getSinglePerson("id", $idOwner);
            ChangesLogsManager::addChangesLogs("C", "Defuncion de " . $person->getFullNameBeginName());

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Search one defuntion by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $string       Necesary string to search
         * @param  string         $order        The type of sort of the Defuntion
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Defuntion] $defuntions     Defuntion objects with the similar name or null
         */
        static function simpleSearchDefuntion($string = '', $order = "id", $begin = 0)
        {
            $tableDefuntion  = DatabaseManager::getNameTable('TABLE_DEFUNTION');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableDefuntion.* 
                          FROM $tableDefuntion JOIN $tablePerson
                          ON $tableDefuntion.idOwner = $tablePerson.id 
                          JOIN $tableChurch 
                          ON $tableDefuntion.idChurch = $tableChurch.id
                          WHERE $tablePerson.names     LIKE '%$string%' OR
                                $tablePerson.lastname1 LIKE '%$string%' OR
                                $tablePerson.lastname2 LIKE '%$string%' OR
                                $tableChurch.name      LIKE '%$string%' OR
                                $tableDefuntion.id       LIKE '%$string%'";

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
                $query = $query . " ORDER BY $tableDefuntion.id";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayDefuntions = DatabaseManager::multiFetchAssoc($query);
            $defuntions      = array();

            if ($arrayDefuntions === NULL)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayDefuntions as $defuntion) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $defuntions[] = self::ArrayToDefuntion($defuntion);
                    $i++;
                }

                return $defuntions;
            }
        }

        /**
         * Search one defuntion by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Defuntion        $defuntion      Pseudo-defuntion with the data to search
         * @param  string         $operator     To search with 'or' or 'and'
         * @param  string         $order        The type of sort of the Defuntion
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Defuntion] $defuntions     Defuntion objects with the similar name or null
         */
        static function advancedSearchDefuntion($defuntion = null, $operator = 'AND', 
                                                $order = 'id',     $begin = 0)
        {
            if ($defuntion === null)
            {
                return null;
            }

            $tableDefuntion = DatabaseManager::getNameTable('TABLE_DEFUNTION');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $celebrationDate = $defuntion->getDeadDate();
            $queryOwner      = "(";
            $posibleOwner    = $defuntion->getIdOwner()[0];
            $queryChurch     = "(";
            $posibleChurch   = $defuntion->getIdChurch();

            if ($posibleOwner !== NULL) //If exist owner id
            {
                for ($i = 0; $i < sizeof($posibleOwner) - 1; $i++)
                {
                    $queryOwner = $queryOwner . $posibleOwner[$i]->getId() . ",";
                }

                $queryOwner  = $queryOwner . $posibleOwner[sizeof($posibleOwner)-1]->getId(). ")";
                $queryOwner  = "(o.id IN " . $queryOwner . ")";
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

            $defuntion->getId() == 0 ? $id = '' : $id = $defuntion->getId();

            $query =   "SELECT b.* 
                        FROM $tableDefuntion AS b LEFT JOIN $tablePerson AS o ON b.idOwner = o.id 
                        JOIN $tableChurch AS c  ON b.idChurch = c.id
                        WHERE b.id          LIKE '%$id%'              $operator
                              b.deadDate    LIKE '%$celebrationDate%' $operator ";

            //Join the Query with the posibiitation query
            if ($queryOwner != '(')
            {
                $query = $query . $queryOwner . " " . $operator. " ";
            }
            else
            {
                $query = $query . "(o.id IN ())" . $operator. " ";
            }

            if ($queryChurch != '(')
            {
                $query = $query . $queryChurch . " ";
            }
            else
            {
                $query = $query . "(c.id IN ())" . " ";
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

            $arrayDefuntions = DatabaseManager::multiFetchAssoc($query);
            $defuntions      = array();

            if ($arrayDefuntions !== NULL)
            {
                $i = 0;
                foreach ($arrayDefuntions as $defuntion) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $defuntions[] = self::ArrayToDefuntion($defuntion);
                    $i++;
                }

                return $defuntions;
            }
            else
            {
                return null;
            }
        }
    }

 ?>
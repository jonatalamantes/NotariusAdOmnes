<?php 
    
    require_once("Rector.php");
    require_once("DatabaseManager.php");

    /**
    * Class for manipulate Rector Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class RectorManager
    {
        /**
         * Transform one Rector object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Rector  $Rector       Rector object to Transform
         * @return  Array   $RectorArray  Array result for transformation or null
         */
        static function RectorToArray($Rector = null)
        {
            if ($Rector === null)
            {
                return null;
            }
            else
            {
                $RectorArray = array();

                $RectorArray['id']             = $Rector->getId(); 
                $RectorArray['type']           = $Rector->getType();
                $RectorArray['status']         = $Rector->getStatus();
                $RectorArray['position']       = $Rector->getPosition();
                $RectorArray['idActualChurch'] = $Rector->getIdActualChurch();
                $RectorArray['idPerson']       = $Rector->getIdPerson();

                return $RectorArray;
            }
        }

        /**
         * Transform one Array object into a Rector Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array     $array      Array object to transform
         * @return  Rector    $Rector     Rector result or null
         */
        static function ArrayToRector($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $Rector  = new Rector($array['id'],             $array['type'], 
                                  $array['status'],         $array['position'],
                                  $array['idActualChurch'], $array['idPerson']);

            return $Rector;
        }

        /**
         * Return if two Rector objects are equals
         * 
         * @param  Rector     $Rector1 Rector 1
         * @param  Rector     $Rector2 Rector 2
         * @return boolean             Result
         */
        static function compareRector($Rector1 = null, $Rector2 = null)
        {
            if ($Rector1 === null || $Rector2 === null)
            {
                return false;
            }
            else
            {
                if (($Rector1->getType()      == $Rector2->getType())     &&
                    ($Rector1->getStatus()    == $Rector2->getStatus())   &&
                    ($Rector1->getIdPerson()  == $Rector2->getIdPerson()) &&
                    ($Rector1->getPosition()  == $Rector2->getPosition()))
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
         * Recover from database one Rector object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key         Key to search
         * @param  string  $value       Value of the key
         * @param  string  $key2        Other Key to search
         * @param  string  $value2      Other Value of the key
         * @param  string  $key3        Other Key to search
         * @param  string  $value3      Other Value of the key
         * @param  string  $key4        Other Key to search
         * @param  string  $value4      Other Value of the key
         * @return Rector  $myRector    Rector result or null
         */
        static function getSingleRector($key = 'id', $value = 0, 
                                        $key2 = '', $value2 = '', 
                                        $key3 = '', $value3 = '', 
                                        $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableRector = DatabaseManager::getNameTable('TABLE_RECTOR');

            $query      = "SELECT $tableRector.*
                           FROM $tableRector 
                           WHERE $tableRector.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableRector.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tableRector.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $tableRector.$key4 = '$value4'";
            }

            $myRector    = DatabaseManager::singleFetchAssoc($query);
            $myRector    = self::ArrayToRector($myRector);

            return $myRector;
        }

        /**
         * Recover all Rector from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[Rector]   $rectors     Array of Rector Object
         */
        static function getAllRectors($order = 'id', $begin = -1)
        {
            $tableRector  = DatabaseManager::getNameTable('TABLE_RECTOR');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableRector.*
                          FROM $tableRector 
                          LEFT JOIN $tablePerson
                          ON $tableRector.idPerson = $tablePerson.id 
                          LEFT JOIN $tableChurch 
                          ON $tableRector.idActualChurch = $tableChurch.id";

            if ($order == 'name')
            {
                $query = $query . " ORDER BY $tablePerson.lastname1";
            }
            else if ($order == 'church')
            {
                $query = $query . " ORDER BY $tableChurch.name";
            }
            else
            {
                $query = $query . " ORDER BY $tableRector.id DESC";
            }

            if ($begin !== -1)
            {
                $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";
            }

            $arrayRectors = DatabaseManager::multiFetchAssoc($query);
            $rectors      = array();

            if ($arrayRectors === null)
            {
                return null;
            }
            else
            {
                if ($begin !== -1)
                {
                    $i = 0;
                    foreach ($arrayRectors as $Rector) 
                    {
                        if ($i == 10)
                        {
                            continue;
                        }

                        $rectors[] = self::ArrayToRector($Rector);
                    }
                }
                else
                {
                    foreach ($arrayRectors as $Rector) 
                    {
                        $rectors[] = self::ArrayToRector($Rector);
                    }
                }
            }

            return $rectors;
        }

        /**
         * Insert one Rector in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Rector   $Rector  The Rector to insert
         * @return boolean           If was possible to insert
         */
        static function addRector($Rector = null)
        {
            if ($Rector === null)
            {
                return false;
            }

            $idPerson       = $Rector->getIdPerson();
            $singleRector   = self::getSingleRector('idPerson', $idPerson);

            if (self::compareRector($singleRector, $Rector) === false)
            {
                $tableRector   = DatabaseManager::getNameTable('TABLE_RECTOR');
                $type           = $Rector->getType();
                $status         = $Rector->getStatus();
                $position       = $Rector->getPosition();
                $idActualChurch = $Rector->getIdActualChurch();

                $query     = "INSERT INTO $tableRector
                              (type, status, position, idActualChurch, idPerson)
                              VALUES 
                              ('$type', '$status', '$position', '$idActualChurch', '$idPerson')";
                
                if (DatabaseManager::singleAffectedRow($query) === true)
                {
                    $id = self::getLastID();

                    if (!self::existFormerRectorChurch($id, $idActualChurch))
                    {
                        return self::addFormerRectorChurch($id, $idActualChurch);
                    }
                    else
                    {
                        return true;
                    }
                }
                else
                {
                    return false;
                }
            }
            else //Rector Exist
            {
                return false;
            }
        }

        /**
         * Get the last ID from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return boolean           If was possible to delete
         */
        static function getLastID()
        {
            $tableRector  = DatabaseManager::getNameTable('TABLE_RECTOR');

            $query     = "SELECT MAX(id) AS Max FROM $tableRector";

            return DatabaseManager::singleFetchAssoc($query)["Max"];
        }

        /**
         * Delete one Rector from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Rector    $Rector  The Rector to delete
         * @return boolean            If was possible to delete
         */
        static function removeRector($Rector = null)
        {
            if ($Rector === null)
            {
                return false;
            }
            else
            {
                $tableRector  = DatabaseManager::getNameTable('TABLE_RECTOR');
                $tableUnion   = DatabaseManager::getNameTable('TABLE_FORMER_RECTOR_CHURCH');
                $id           = $Rector->getId();

                $query     = "DELETE FROM $tableUnion
                              WHERE $tableUnion.idRector = $id";

                DatabaseManager::singleAffectedRow($query);

                $query     = "DELETE FROM $tableRector
                              WHERE $tableRector.id = $id";

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * Update one Rector in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Rector $Rector  The Rector to update
         * @return boolean         If was possible to update
         */
        static function updateRector($Rector = null)
        {
            if ($Rector === null)
            {
                return false;
            }

            $tableRector    = DatabaseManager::getNameTable('TABLE_RECTOR');
            $id             = $Rector->getId();
            $type           = $Rector->getType();
            $status         = $Rector->getStatus();
            $position       = $Rector->getPosition();
            $idActualChurch = $Rector->getIdActualChurch();
            $idPerson       = $Rector->getIdPerson();

            $query     = "UPDATE $tableRector
                          SET type = '$type', status = '$status', position = '$position', 
                              idActualChurch = '$idActualChurch', idPerson = '$idPerson'
                          WHERE $tableRector.id = $id";

            if (DatabaseManager::singleAffectedRow($query) === true)
            {
                if (!self::existFormerRectorChurch($id, $idActualChurch))
                {
                    return self::addFormerRectorChurch($id, $idActualChurch);
                }
                else
                {
                    return true;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * Search one Rector by one similar names
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string        $name      Name of Rector to search
         * @param  string        $operator  Operator for operations (AND or OR)
         * @param  string        $order     The type of sort of the Rector
         * @param  integer       $begin     The number of page to display the registry
         * @return Array[Rector] $rectors   Rector objects with the similar names
         */
        static function searchRector($name = '', $operator = 'OR', $order = 'id', $begin = 0)
        {
            if ($value === '')
            {
                return null;
            }

            $tableRector  = DatabaseManager::getNameTable('TABLE_RECTOR');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableRector.*
                          FROM $tableRector JOIN $tablePerson 
                          ON $tablePerson.id = $tableRector.idPerson
                          WHERE $tableRector.id        LIKE '%$name%' $operator
                                $tablePerson.names     LIKE '%$name%' $operator
                                $tablePerson.lastname1 LIKE '%$name%' $operator
                                $tablePerson.lastname2 LIKE '%$name%'";

            if ($order === 'name')
            {
                $query = $query . " ORDER BY $tablePerson.lastname1";
            }
            else if ($order === 'church')
            {
                $query = $query . " ORDER BY $tableChurch.name";
            }
            else
            {
                $query = $query . " ORDER BY $tableRector.id DESC";
            }

            if ($begin !== -1)
            {
                $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";
            }

            $arrayRectors = DatabaseManager::multiFetchAssoc($query);
            $rectors      = array();

            if ($arrayRectors === null)
            {
                return null;
            }

            foreach ($arrayRectors as $Rector) 
            {
                $rectors[] = self::ArrayToRector($Rector);
            }

            return $rectors;
        }

        /**
         * Search one rector by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Rector        $rector      pseudo-rector with the data to search
         * @param  string        $operator    To search with 'OR' or 'AND'
         * @param  string        $order       The type of sort of the Rector
         * @param  integer       $begin       The number of page to display the registry
         * @return Array[Rector] $rectors     Rector objects with the similar name or null
         */
        static function advancedSearchRector($rector = null, $operator = 'AND', 
                                             $order = 'id', $begin = 0)
        {
            if ($rector === null)
            {
                return null;
            }

            $tableRector  = DatabaseManager::getNameTable('TABLE_RECTOR');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $rector->getId() == 0 ? $id = '' : $id = $rector->getId();
            $type          = $rector->getType();
            $status        = $rector->getStatus();
            $position      = $rector->getPosition();
            $queryOwner    = "(";
            $posibleOwner  = $rector->getIdPerson();
            $queryChurch   = "(";
            $posibleChurch = $rector->getIdActualChurch();

            if ($posibleOwner !== NULL)
            {
                for ($i = 0; $i < sizeof($posibleOwner) - 1; $i++)
                {
                    $queryOwner = $queryOwner . $posibleOwner[$i]->getId() . ",";
                }

                $queryOwner  = $queryOwner . $posibleOwner[sizeof($posibleOwner)-1]->getId(). ")";
                $queryOwner  = "(o.id IN " . $queryOwner . " OR o.id IS NULL)";
            }
    
            if ($posibleChurch !== NULL)
            {
                for ($i = 0; $i < sizeof($posibleChurch) - 1; $i++)
                {
                    $queryChurch = $queryChurch . $posibleChurch[$i]->getId() . ",";
                }

                $queryChurch  = $queryChurch.$posibleChurch[sizeof($posibleChurch)-1]->getId(). ")";
                $queryChurch  = "(c.id IN " . $queryChurch . " OR c.id IS NULL)";
            }

            $query =   "SELECT r.* 
                        FROM $tableRector AS r LEFT JOIN $tablePerson AS o ON r.idPerson = o.id 
                        JOIN $tableChurch AS c  ON r.idActualChurch = c.id
                        WHERE r.id       LIKE '%$id%'       $operator
                              r.type     LIKE '%$type%'     $operator
                              r.status   LIKE '%$status%'   $operator
                              r.position LIKE '%$position%' $operator";

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
                $query = $query . "(c.id IN ()) ";
            }

            if ($order == 'name')
            {
                $query = $query . " ORDER BY o.names";
            }
            else if ($order == 'church')
            {
                $query = $query . " ORDER BY c.name";
            }
            else
            {
                $query = $query . " ORDER BY r.id";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayRectors = DatabaseManager::multiFetchAssoc($query);
            $rectors      = array();

            if ($arrayRectors !== NULL)
            {
                $i = 0;
                foreach ($arrayRectors as $rector) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $rectors[] = self::ArrayToRector($rector);
                    $i++;
                }

                return $rectors;
            }
            else
            {
                return null;
            }
        }

        /**
         * Add a new FormerRectorChurch in the database
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param string   $idRector   Id of one rector
         * @param string   $idChurch   Id of one church
         * @return  boolean            If was posible add the new registry
         */
        static function addFormerRectorChurch($idRector = '', $idChurch = '')
        {
            if (self::existFormerRectorChurch($idRector, $idChurch))
            {
                return false;
            }
            else
            {
                $tableName = DatabaseManager::getNameTable('TABLE_FORMER_RECTOR_CHURCH');

                $query = "INSERT INTO $tableName
                          (idRector, idChurch)
                          VALUES
                          ('$idRector', '$idChurch')";

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         *  Return if exist one 'formerRectorChurch' in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string    $idRector   The id of one rector
         * @param  string    $idChurch   The id of one church
         * @return boolean               True if exist in the database, else false
         */
        static function existFormerRectorChurch($idRector = '', $idChurch = '')
        {
            if ($idRector == '' || $idChurch == '')
            {
                return false;
            }
            else
            {
                $tableName = DatabaseManager::getNameTable('TABLE_FORMER_RECTOR_CHURCH');

                $query = "SELECT $tableName.*
                          FROM $tableName 
                          WHERE $tableName.idRector = $idRector AND
                                $tableName.idChurch = $idChurch";

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * Recover all the rector from one church
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string          $idChurch   Id of one church
         * @return Array[Rector]               Rector that worked in the church
         */
        static function getAllFormerRectors($idChurch = '', $order = 'name', $begin = -1)
        {
            if ($idChurch == '')
            {
                return null;
            }
            else
            {
            $tableRector  = DatabaseManager::getNameTable('TABLE_RECTOR');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableUnion   = DatabaseManager::getNameTable('TABLE_FORMER_RECTOR_CHURCH');

            $query     = "SELECT $tableRector.*
                          FROM $tableRector 
                          LEFT JOIN $tablePerson
                          ON $tableRector.idPerson = $tablePerson.id 
                          LEFT JOIN $tableChurch 
                          ON $tableRector.idActualChurch = $tableChurch.id
                          LEFT JOIN $tableUnion
                          ON $tableUnion.idRector = $tableRector.id
                          WHERE $tableUnion.idChurch = $idChurch ";

            if ($order == 'name')
            {
                $query = $query . " ORDER BY $tablePerson.lastname1";
            }
            else if ($order == 'church')
            {
                $query = $query . " ORDER BY $tableChurch.name";
            }
            else
            {
                $query = $query . " ORDER BY $tableRector.id DESC";
            }

            if ($begin !== -1)
            {
                $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";
            }

            $arrayRectors = DatabaseManager::multiFetchAssoc($query);
            $rectors      = array();

            if ($arrayRectors === null)
            {
                return null;
            }
            else
            {
                if ($begin !== -1)
                {
                    $i = 0;
                    foreach ($arrayRectors as $Rector) 
                    {
                        if ($i == 10)
                        {
                            continue;
                        }

                        $rectors[] = self::ArrayToRector($Rector);
                    }
                }
                else
                {
                    foreach ($arrayRectors as $Rector) 
                    {
                        $rectors[] = self::ArrayToRector($Rector);
                    }
                }
            }

            return $rectors;
            }
        }

        /**
         * Recover all the rector from one church
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string          $idChurch   Id of one church
         * @return Array[Church]               Rector that worked in the church
         */
        static function getAllFormerChurchs($idRector = '', $order = 'id', $begin = -1)
        {
            if ($idRector == '')
            {
                return null;
            }
            else
            {
                $tableRector  = DatabaseManager::getNameTable('TABLE_RECTOR');
                $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');
                $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
                $tableUnion   = DatabaseManager::getNameTable('TABLE_FORMER_RECTOR_CHURCH');

                $query     = "SELECT $tableChurch.*
                              FROM $tableChurch
                              LEFT JOIN $tableUnion
                              ON $tableUnion.idChurch = $tableChurch.id
                              WHERE $tableUnion.idRector = $idRector
                              ORDER BY $order";

                if ($begin !== -1)
                {
                    $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";
                }

                $arrayChurchs = DatabaseManager::multiFetchAssoc($query);
                $churchs      = array();

                if ($arrayChurchs === null)
                {
                    return null;
                }
                else
                {
                    if ($begin !== -1)
                    {
                        $i = 0;
                        foreach ($arrayChurchs as $church) 
                        {
                            if ($i == 10)
                            {
                                continue;
                            }

                            $churchs[] = ChurchManager::ArrayToChurch($church);
                            $i++;
                        }
                    }
                    else
                    {
                        foreach ($arrayChurchs as $church) 
                        {
                            $churchs[] = ChurchManager::ArrayToChurch($church);
                        } 
                    }

                    return $churchs;
                }
            }
        }
    }

 ?>
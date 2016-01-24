<?php 
    
    require_once("Church.php");
    require_once("DatabaseManager.php");
    require_once("CityManager.php");
    require_once("ChangesLogsManager.php");

    /**
    * Class for manipulate Church Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ChurchManager
    {
        /**
         * Transform one Church object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Church  $church  Church object to Transform
         * @return  Array   $church  Array result for transformation or null
         */
        static function ChurchToArray($church = null)
        {
            if ($church === null)
            {
                return null;
            }
            else
            {
                $church = array();

                $church['id']          = $church->getId();
                $church['name']        = $church->getName();
                $church['type']        = $church->getType();
                $church['code']        = $church->getCode();
                $church['address']     = $church->getAddress();
                $church['colony']      = $church->getColony();
                $church['postalCode']  = $church->getPostalCode();
                $church['phoneNumber'] = $church->getPhoneNumber();
                $church['idVicar']     = $church->getIdVicar();
                $church['idDean']      = $church->getIdDean();
                $church['idCity']      = $church->getIdCity();
                $church['idNiche']     = $church->getIdNiche();

                return $church;
            }
        }

        /**
         * Transform one Array object into a Church Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array   $church   Array object to transform
         * @return  Church  $church   Church result or null
         */
        static function ArrayToChurch($church = array())
        {
            if ($church === null)
            {
                return null;
            }

            $church = new Church($church['id'],         $church['name'],        $church['type'], 
                                 $church['code'],       $church['address'],     $church['colony'], 
                                 $church['postalCode'], $church['phoneNumber'], $church['idVicar'], 
                                 $church['idDean'],     $church['idCity'],      $church['idNiche']);

            return $church;
        }

        /**
         * Transform one Dean object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Dean    $dean      Dean object to transform
         * @return  Array   $array     Array result or null
         */
        static function DeanToArray($dean = null)
        {
            if ($dean === null)
            {
                return null;
            }

            $array = array();

            $array['id']   = $dean->getId();
            $array['name'] = $dean->getName();

            return $array;
        }

        /**
         * Transform one Array object into a Dean Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array   $array     Array object to transform
         * @return  Dean    $dean      Dean result or null
         */
        static function ArrayToDean($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $dean = new Dean($array['id'], $array["name"]);
            return $dean;
        }

        /**
         * Transform one Vicar object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Vicar    $vicar      Vicar object to transform
         * @return  Array    $array      Array result or null
         */
        static function VicarToArray($vicar = null)
        {
            if ($vicar === null)
            {
                return null;
            }

            $array = array();

            $array['id']   = $vicar->getId();
            $array['name'] = $vicar->getName();

            return $array;
        }

        /**
         * Transform one Array object into a Vicar Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array    $array      Array object to transform
         * @return  Vicar    $vicar      Vicar result or null
         */
        static function ArrayToVicar($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $vicar = new Vicar($array['id'], $array['name']);
            return $vicar;
        }

        /**
         * Transform one Niche object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Niche    $niche      Niche object to transform
         * @return  Array    $array      Array result or null
         */
        static function NicheToArray($niche = null)
        {
            if ($niche === null)
            {
                return null;
            }

            $array = array();

            $array['id']     = $niche->getId();
            $array['maxCol'] = $niche->getMaxRow();
            $array['maxRow'] = $niche->getMaxCol();
            $array['size']   = $niche->getSize();

            return $array;
        }

        /**
         * Transform one Array object into a Niche Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array    $array      Array object to transform
         * @return  Niche    $niche      Niche result or null
         */
        static function ArrayToNiche($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $niche = new Niche($array['id'], $array['maxCol'], $array['maxRow'], $array['size']);
            return $niche;
        }

        /**
         * Return if two church objects are equals
         * 
         * @param  Church     $church1 Church 1
         * @param  Church     $church2 Church 2
         * @return boolean             Result
         */
        static function compareChurch($church1 = null, $church2 = null)
        {
            if ($church1 === null || $church2 === null)
            {
                return false;
            }
            else
            {
                if (($church1->getName()    == $church2->getName()) &&
                    ($church1->getType()    == $church2->getType()) &&
                    ($church1->getCode()    == $church2->getCode()) &&
                    ($church1->getAddress() == $church2->getAddress()))
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
         * Return if two dean objects are equals
         * 
         * @param  Dean     $dean1   Dean 1
         * @param  Dean     $dean2   Dean 2
         * @return boolean           Result
         */
        static function compareDean($dean1 = null, $dean2 = null)
        {
            if ($dean1 === null || $dean2 === null)
            {
                return false;
            }
            else
            {
                if ($dean1->getName() == $dean2->getName())
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
         * Return if two vicar objects are equals
         * 
         * @param  Vicar     $vicar1   Vicar 1
         * @param  Vicar     $vicar2   Vicar 2
         * @return boolean             Result
         */
        static function compareVicar($vicar1 = null, $vicar2 = null)
        {
            if ($vicar1 === null || $vicar2 === null)
            {
                return false;
            }
            else
            {
                if ($vicar1->getName() == $vicar2->getName())
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
         * Return if two niche objects are equals
         * 
         * @param  Niche     $niche1   Niche 1
         * @param  Niche     $niche2   Niche 2
         * @return boolean             Result
         */
        static function compareNiche($niche1 = null, $niche2 = null)
        {
            if ($niche1 === null || $niche2 === null)
            {
                return false;
            }
            else
            {
                if (($niche1->getMaxCol() == $niche2->getMaxCol()) &&
                    ($niche1->getMaxRow() == $niche2->getMaxRow()) &&
                    ($niche1->getSize()   == $niche2->getSize()))
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
         * Recover from database one Dean object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       Key to search
         * @param  string  $value     Value of the key
         * @return Dean    $myDean    Dean result or null
         */
        static function getSingleDean($key = 'id', $value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableDean = DatabaseManager::getNameTable('TABLE_DEAN');

            $query      = "SELECT $tableDean.*
                           FROM $tableDean 
                           WHERE $tableDean.$key = '$value'";

            $myDean    = DatabaseManager::singleFetchAssoc($query);
            $myDean    = self::ArrayToDean($myDean);

            return $myDean;
        }

        /**
         * Recover from database one Vicar object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       Key to search
         * @param  string  $value     Value of the key
         * @return Vicar   $myVicar   Vicar result or null
         */
        static function getSingleVicar($key = 'id', $value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableVicar = DatabaseManager::getNameTable('TABLE_VICAR');

            $query      = "SELECT $tableVicar.*
                           FROM $tableVicar 
                           WHERE $tableVicar.$key = '$value'";

            $myVicar    = DatabaseManager::singleFetchAssoc($query);
            $myVicar    = self::ArrayToVicar($myVicar);

            return $myVicar;
        }

        /**
         * Recover from database one Niche object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       Key to search
         * @param  string  $value     Value of the key
         * @param  string  $key2      Other Key to search
         * @param  string  $value2    Other Value of the key
         * @param  string  $key3      Other Key to search
         * @param  string  $value3    Other Value of the key
         * @return Niche   $myNiche   Niche result or null
         */
        static function getSingleNiche($key = 'id', $value = '', 
                                       $key2 = '', $value2 = '', 
                                       $key3 = '', $value3 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableNiche = DatabaseManager::getNameTable('TABLE_NICHE');

            $query      = "SELECT $tableNiche.*
                           FROM $tableNiche 
                           WHERE $tableNiche.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableNiche.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tableNiche.$key3 = '$value3'";
            }

            $myNiche    = DatabaseManager::singleFetchAssoc($query);
            $myNiche    = self::ArrayToNiche($myNiche);

            return $myNiche;
        }

        /**
         * Recover from database one Church object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       Key to search
         * @param  string  $value     Value of the key
         * @return Church  $church    Church result or null
         */
        static function getSingleChurch($key = 'id', $value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $query     = "SELECT $tableChurch.*
                           FROM $tableChurch 
                           WHERE $tableChurch.$key = '$value'";

            $church      = DatabaseManager::singleFetchAssoc($query);
            $church      = self::ArrayToChurch($church);

            return $church;
        }

        /**
         * Recover all Church from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $order        The type of sort of the Church
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Church]  $churchs      Array of Church Object
         */
        static function getAllChurchs($order = 'id DESC', $begin = -1)
        {
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $query     = "SELECT $tableChurch.*
                           FROM $tableChurch
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

                        $churchs[] = self::ArrayToChurch($church);
                        $i++;
                    }
                }
                else
                {
                    foreach ($arrayChurchs as $church) 
                    {
                        $churchs[] = self::ArrayToChurch($church);
                    } 
                }

                return $churchs;
            }
        }

        /**
         * Recover all Dean from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[Dean]     $deans     Array of Dean Object
         */
        static function getAllDeans()
        {
            $tableDean  = DatabaseManager::getNameTable('TABLE_DEAN');

            $query     = "SELECT $tableDean.*
                           FROM $tableDean
                           ORDER BY name";

            $arrayDeans = DatabaseManager::multiFetchAssoc($query);
            $deans      = array();

            foreach ($arrayDeans as $dean) 
            {
                $deans[] = self::ArrayToDean($dean);
            }

            return $deans;
        }

        /**
         * Recover all Vicar from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[Vicar]     $vicars     Array of Vicar Object
         */
        static function getAllVicars()
        {
            $tableVicar  = DatabaseManager::getNameTable('TABLE_VICAR');

            $query     = "SELECT $tableVicar.*
                           FROM $tableVicar
                           ORDER BY name";

            $arrayVicars = DatabaseManager::multiFetchAssoc($query);
            $vicars      = array();

            foreach ($arrayVicars as $vicar) 
            {
                $vicars[] = self::ArrayToVicar($vicar);
            }

            return $vicars;
        }

        /**
         * Recover all Niche from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[Niche]     $niches     Array of Niche Object
         */
        static function getAllNiches()
        {
            $tableNiche  = DatabaseManager::getNameTable('TABLE_NICHE');

            $query     = "SELECT $tableNiche.*
                           FROM $tableNiche
                           ORDER BY maxRow";

            $arrayNiches = DatabaseManager::multiFetchAssoc($query);
            $niches      = array();

            foreach ($arrayNiches as $niche) 
            {
                $niches[] = self::ArrayToNiche($niche);
            }

            return $niches;
        }

        /**
         * Insert one church in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Church   $church  The church to insert
         * @return boolean           If was possible to insert
         */
        static function addChurch($church = null)
        {
            if ($church === null)
            {
                return false;
            }

            $name         = $church->getName();
            $singleChurch = self::getSingleChurch('name', $name);

            if (self::compareChurch($singleChurch, $church) === false)
            {
                $tableChurch = DatabaseManager::getNameTable('TABLE_CHURCH');

                $name        = $church->getName();
                $type        = $church->getType();
                $code        = $church->getCode();
                $address     = $church->getAddress();
                $colony      = $church->getColony();
                $postalCode  = $church->getPostalCode();
                $phoneNumber = $church->getPhoneNumber();
                $idVicar     = $church->getIdVicar();
                $idDean      = $church->getIdDean();
                $idCity      = $church->getIdCity();
                $idNiche     = $church->getIdNiche();

                $query     = "INSERT INTO Church 
                             (name,   type,       code,        address, 
                              colony, postalCode, phoneNumber, idVicar, 
                              idDean, idCity,     idNiche) 
                             VALUES 
                             ('$name',   '$type',       '$code',        '$address', 
                              '$colony', '$postalCode', '$phoneNumber', '$idVicar', 
                              '$idDean',  $idCity,       $idNiche)";

                ChangesLogsManager::addChangesLogs("I", "Insercion de " . $church->getName());

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Church Exist
            {
                return false;
            }
        }

        /**
         * Insert one dean in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Dean      $dean  The dean to insert
         * @return boolean          If was possible to insert
         */
        static function addDean($dean = null)
        {
            if ($dean === null)
            {
                return false;
            }

            $name  = $dean->getName();
            $singleDean = self::getSingleDean('name', $name);

            if (self::compareDean($singleDean, $dean) === false) 
            {
                $tableDean = DatabaseManager::getNameTable('TABLE_DEAN');
                $name       = $dean->getName();

                $query     = "INSERT INTO $tableDean
                              (name)
                              VALUES 
                              ('$name')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Dean exist
            {
                return false;
            }
        }


        /**
         * Insert one vicar in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Vicar    $vicar  The vicar to insert
         * @return boolean          If was possible to insert
         */
        static function addVicar($vicar = null)
        {
            if ($vicar === null)
            {
                return false;
            }

            $name  = $vicar->getName();
            $singleVicar = self::getSingleVicar('name', $name);

            if (self::compareVicar($singleVicar, $vicar) === false)
            {
                $tableVicar = DatabaseManager::getNameTable('TABLE_VICAR');
                $name       = $vicar->getName();

                $query     = "INSERT INTO $tableVicar
                              (name)
                              VALUES 
                              ('$name')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Vicar exist
            {
                return false;
            }
        }

        /**
         * Insert one niche in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Niche $niche  The niche to insert
         * @return boolean       If was possible to insert
         */
        static function addNiche($niche = null)
        {
            if ($niche === null)
            {
                return false;
            }

            $maxCol  = $niche->getMaxCol();
            $maxRow  = $niche->getMaxRow();
            $size    = $niche->getSize();

            $singleNiche = self::getSingleNiche('maxCol', $maxCol, 
                                                'maxRow', $maxRow, 
                                                'size',   $size);

            if ($singleNiche === null)
            {
                $tableNiche = DatabaseManager::getNameTable('TABLE_NICHE');

                $query     = "INSERT INTO $tableNiche
                              (maxCol, maxRow, size)
                              VALUES 
                              ('$maxCol', '$maxRow', '$size')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Niche exist
            {
                return false;
            }
        }

        /**
         * Delete one church from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Church   $church  The church to delete
         * @return boolean           If was possible to delete
         */
        static function removeChurch($church = null)
        {
            if ($church === null)
            {
                return false;
            }
            else
            {
                $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');
                $id         = $church->getId();

                $query     = "DELETE FROM $tableChurch
                              WHERE $tableChurch.id = $id";

                ChangesLogsManager::addChangesLogs("D", "Iglesia de " . $church->getName());

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * Update one church in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Church $church  The church to update
         * @return boolean         If was possible to update
         */
        static function updateChurch($church = null)
        {
            if ($church === null)
            {
                return false;
            }

            $tableChurch = DatabaseManager::getNameTable('TABLE_CHURCH');

            $id          = $church->getId();
            $name        = $church->getName();
            $type        = $church->getType();
            $code        = $church->getCode();
            $address     = $church->getAddress();
            $colony      = $church->getColony();
            $postalCode  = $church->getPostalCode();
            $phoneNumber = $church->getPhoneNumber();
            $idVicar     = $church->getIdVicar();
            $idDean      = $church->getIdDean();
            $idCity      = $church->getIdCity();
            $idNiche     = $church->getIdNiche();

            $query     = "UPDATE $tableChurch
                          SET name        = '$name', 
                              type        = '$type', 
                              code        = '$code', 
                              address     = '$address', 
                              colony      = '$colony', 
                              postalCode  = '$postalCode', 
                              phoneNumber = '$phoneNumber', 
                              idVicar     = '$idVicar', 
                              idDean      = '$idDean', 
                              idCity      = '$idCity', 
                              idNiche     = $idNiche 
                          WHERE $tableChurch.id = $id";

            ChangesLogsManager::addChangesLogs("C", "Iglesia de " . $church->getName());

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Search one church by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Church        $church      Pseudo-church with the data to search
         * @param  string        $order       The type of sort of the Church
         * @param  integer       $begin       The number of page to display the registry
         * @return Array[Church] $churchs     Church objects with the similar name or null
         */
        static function simpleSearchChurch($string = '', $order = 'id', $begin = -1)
        {
            $tableChurch = DatabaseManager::getNameTable('TABLE_CHURCH');
            $operator    = 'OR';

            $query     = "SELECT $tableChurch.*
                          FROM $tableChurch
                          WHERE id          LIKE '%$string%' $operator
                                name        LIKE '%$string%'
                          ORDER BY $order";

            if ($begin !== -1)
            {
                $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";
            }

            $arrayChurchs = DatabaseManager::multiFetchAssoc($query);
            $churchs = array();

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

                        $churchs[] = self::ArrayToChurch($church);
                        $i++;
                    }
                }
                else
                {
                    foreach ($arrayChurchs as $church) 
                    {
                        $churchs[] = self::ArrayToChurch($church);
                    }
                }

                return $churchs;
            }
        }

        /**
         * Search one church by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Church        $church      Pseudo-church with the data to search
         * @param  string        $order       The type of sort of the Church
         * @param  integer       $begin       The number of page to display the registry
         * @param  string        $operator    To search with 'or' or 'and'
         * @return Array[Church] $churchs     Church objects with the similar name or null
         */
        static function advancedSearchChurch($church = null, $order = 'id', 
                                             $begin = -1, $operator = 'AND')
        {
            if ($church === null)
            {
                return null;
            }

            $tableChurch = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tableVicar  = DatabaseManager::getNameTable('TABLE_VICAR');
            $tableDean   = DatabaseManager::getNameTable('TABLE_DEAN');
            $tableCity   = DatabaseManager::getNameTable('TABLE_CITY');

            $church->getId() <= 0 ? $id = '' : $id = $church->getId();
            $name        = $church->getName();
            $type        = $church->getType();
            $church->getCode() <= 0 ? $code = '' : $code = $church->getCode();
            $address     = $church->getAddress();
            $colony      = $church->getColony();
            $church->getPostalCode() <= 0 ? $postalCode = '':$postalCode = $church->getPostalCode();
            $phoneNumber = $church->getPhoneNumber();
            $vicar       = $church->getIdVicar();
            $dean        = $church->getIdDean();
            $city        = $church->getIdCity();

            $query     = "SELECT $tableChurch.*
                          FROM $tableChurch 
                                LEFT JOIN $tableDean  ON $tableChurch.idDean  = $tableDean.id
                                LEFT JOIN $tableVicar ON $tableChurch.idVicar = $tableVicar.id
                                LEFT JOIN $tableCity  ON $tableChurch.idCity  = $tableCity.id
                          WHERE $tableChurch.id          LIKE '%$id%'          $operator
                                $tableChurch.name        LIKE '%$name%'        $operator
                                $tableChurch.type        LIKE '%$type%'        $operator
                                $tableChurch.code        LIKE '%$code%'        $operator
                                $tableChurch.address     LIKE '%$address%'     $operator
                                $tableChurch.colony      LIKE '%$colony%'      $operator
                                $tableChurch.postalCode  LIKE '%$postalCode%'  $operator
                                $tableChurch.phoneNumber LIKE '%$phoneNumber%' $operator
                                ($tableDean.id           LIKE '%$dean%'        OR
                                 $tableDean.name         LIKE '%$dean%'      ) $operator
                                ($tableVicar.id          LIKE '%$vicar%'       OR
                                 $tableVicar.name        LIKE '%$vicar%'     ) $operator
                                ($tableCity.id           LIKE '%$city%'        OR
                                 $tableCity.name         LIKE '%$city%'      )
                                ORDER BY $order";

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayChurchs = DatabaseManager::multiFetchAssoc($query);

            if ($arrayChurchs === null)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayChurchs as $church) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $churchs[] = self::ArrayToChurch($church);
                    $i++;
                }

                return $churchs;
            }
        }
    }

 ?>
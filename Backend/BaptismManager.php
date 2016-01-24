<?php 
    
    require_once("Baptism.php");
    require_once("CityManager.php");
    require_once("ChurchManager.php");
    require_once("PersonManager.php");
    require_once("ChangesLogsManager.php");

    /**
    * Class for manipulate Baptism Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class BaptismManager
    {
        /**
         * Transform one Baptism object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Baptism $baptism    Baptism object to Transform
         * @return  Array   $baptism    Array result for transformation or null
         */
        static function BaptismToArray($baptism = null)
        {
            if ($baptism === null)
            {
                return null;
            }
            else
            {
                $baptismArray = array();

                $baptismArray['id']              = $baptism->getId();
                $baptismArray['baptismDate']     = $baptism->getCelebrationDate();
                $baptismArray['bornPlace']       = $baptism->getBornPlace();
                $baptismArray['bornDate']        = $baptism->getBornDate();
                $baptismArray['legitimate']      = $baptism->getLegitimate();
                $baptismArray['idOwner']         = $baptism->getIdOwner();
                $baptismArray['idGodFather']     = $baptism->getIdGodFather();
                $baptismArray['idGodMother']     = $baptism->getIdGodMother();
                $baptismArray['idBookRegistry']  = $baptism->getIdBookRegistry();
                $baptismArray['idCivilRegistry'] = $baptism->getIdCivilRegistry();
                $baptismArray['idChurch']        = $baptism->getIdChurch();
                $baptismArray['idRector']        = $baptism->getIdRector();

                return $baptismArray;
            }
        }

        /**
         * Transform one Array object into a Baptism Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array    $baptism   Array object to transform
         * @return  Baptism  $baptism   Baptism result or null
         */
        static function ArrayToBaptism($baptismArray = array())
        {
            if ($baptismArray === null)
            {
                return null;
            }

            $baptism = new Baptism($baptismArray['id'],            $baptismArray['baptismDate'], 
                                   $baptismArray['bornPlace'],     $baptismArray['bornDate'], 
                                   $baptismArray['legitimate'],    $baptismArray['idOwner'], 
                                   $baptismArray['idGodFather'],   $baptismArray['idGodMother'], 
                                   $baptismArray['idBookRegistry'],$baptismArray['idCivilRegistry'], 
                                   $baptismArray['idChurch'],      $baptismArray['idRector']);

            return $baptism;
        }

        /**
         * Transform one OfficeCivilRegistry object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   OfficeCivilRegistry $officeCivilRegistry OfficeCivilRegistry object to transform
         * @return  Array               $array               Array result or null
         */
        static function OfficeCivilRegistryToArray($officeCivilRegistry = null)
        {
            if ($officeCivilRegistry === null)
            {
                return null;
            }

            $array = array();

            $array['id']     = $officeCivilRegistry->getId();
            $array['number'] = $officeCivilRegistry->getNumber();
            $array['idCity'] = $officeCivilRegistry->getIdCity();

            return $array;
        }

        /**
         * Transform one Array object into a OfficeCivilRegistry Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array                $array                Array object to transform
         * @return  OfficeCivilRegistry  $officeCivilRegistry  OfficeCivilRegistry result or null
         */
        static function ArrayToOfficeCivilRegistry($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $officeCivilRegistry = new OfficeCivilRegistry($array['id'], 
                                                           $array['number'], 
                                                           $array["idCity"]);

            return $officeCivilRegistry;
        }

        /**
         * Transform one CivilRegistry object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   CivilRegistry    $civilRegistry      CivilRegistry object to transform
         * @return  Array            $array              Array result or null
         */
        static function CivilRegistryToArray($civilRegistry = null)
        {
            if ($civilRegistry === null)
            {
                return null;
            }

            $array = array();

            $array['id']       = $civilRegistry->getId();
            $array['number']   = $civilRegistry->getNumber();
            $array['book']     = $civilRegistry->getBook();
            $array['page']     = $civilRegistry->getPage();
            $array['idOfficineCivilRegistry'] = $civilRegistry->getIdOffice();

            return $array;
        }

        /**
         * Transform one Array object into a CivilRegistry Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array            $array              Array object to transform
         * @return  CivilRegistry    $civilRegistry      CivilRegistry result or null
         */
        static function ArrayToCivilRegistry($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $civilRegistry = new CivilRegistry($array['id'], $array['number'], $array['book'], 
                                               $array["page"], $array['idOfficineCivilRegistry']);
            return $civilRegistry;
        }

        /**
         * Transform one BaptismRegistry object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   BaptismRegistry    $baptismRegistry      BaptismRegistry object to transform
         * @return  Array              $array                Array result or null
         */
        static function BaptismRegistryToArray($baptismRegistry = null)
        {
            if ($baptismRegistry === null)
            {
                return null;
            }

            $array = array();

            $array['id']      = $baptismRegistry->getId();
            $array['book']    = $baptismRegistry->getBook();
            $array['number']  = $baptismRegistry->getNumber();
            $array['page']    = $baptismRegistry->getPage();
            $array['reverse'] = $baptismRegistry->getReverse();

            return $array;
        }

        /**
         * Transform one Array object into a BaptismRegistry Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array              $array                Array object to transform
         * @return  BaptismRegistry    $baptismRegistry      BaptismRegistry result or null
         */
        static function ArrayToBaptismRegistry($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $baptismRegistry = new BaptismRegistry($array['id'], $array['book'], $array['number'], 
                                                   $array['page'], $array['reverse']);
            return $baptismRegistry;
        }

        /**
         * Return if two baptism objects are equals
         * 
         * @param  Baptism     $baptism1 Baptism 1
         * @param  Baptism     $baptism2 Baptism 2
         * @return boolean               Result
         */
        static function compareBaptism($baptism1 = null, $baptism2 = null)
        {
            if ($baptism1 === null || $baptism2 === null)
            {
                return false;
            }
            else
            {
                if (($baptism1->getIdOwner()         == $baptism2->getIdOwner())   &&
                    ($baptism1->getBornPlace()       == $baptism2->getBornPlace()) &&
                    ($baptism1->getBornDate()        == $baptism2->getBornDate())  &&
                    ($baptism1->getCelebrationDate() == $baptism2->getCelebrationDate()))
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
         * Return if two officeCivilRegistry objects are equals
         * 
         * @param  OfficeCivilRegistry     $officeCivilRegistry1   OfficeCivilRegistry 1
         * @param  OfficeCivilRegistry     $officeCivilRegistry2   OfficeCivilRegistry 2
         * @return boolean                                         Result
         */
        static function compareOfficeCivilRegistry($officeCivilReg1 = null, $officeCivilReg2 = null)
        {
            if ($officeCivilReg1 === null || $officeCivilReg2 === null)
            {
                return false;
            }
            else
            {
                if ($officeCivilReg1->getIdCity() == $officeCivilReg2->getIdCity() &&
                    $officeCivilReg1->getNumber() == $officeCivilReg2->getNumber())
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
         * Return if two civilRegistry objects are equals
         * 
         * @param  CivilRegistry     $civilRegistry1   CivilRegistry 1
         * @param  CivilRegistry     $civilRegistry2   CivilRegistry 2
         * @return boolean                             Result
         */
        static function compareCivilRegistry($civilRegistry1 = null, $civilRegistry2 = null)
        {
            if ($civilRegistry1 === null || $civilRegistry2 === null)
            {
                return false;
            }
            else
            {
                if (($civilRegistry1->getNumber()   == $civilRegistry2->getNumber()) &&
                    ($civilRegistry1->getBook()     == $civilRegistry2->getBook())   &&
                    ($civilRegistry1->getIdOffice() == $civilRegistry2->getIdOffice()))
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
         * Return if two baptismRegistry objects are equals
         * 
         * @param  BaptismRegistry     $baptismRegistry1   BaptismRegistry 1
         * @param  BaptismRegistry     $baptismRegistry2   BaptismRegistry 2
         * @return boolean                                 Result
         */
        static function compareBaptismRegistry($baptismRegistry1 = null, $baptismRegistry2 = null)
        {
            if ($baptismRegistry1 === null || $baptismRegistry2 === null)
            {
                return false;
            }
            else
            {
                if (($baptismRegistry1->getBook()    == $baptismRegistry2->getBook())    &&
                    ($baptismRegistry1->getNumber()  == $baptismRegistry2->getNumber())  &&
                    ($baptismRegistry1->getReverse() == $baptismRegistry2->getReverse()) &&
                    ($baptismRegistry1->getPage()    == $baptismRegistry2->getPage()))
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
         * Recover from database one OfficeCivilRegistry object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string               $key                     Key to search
         * @param  string               $value                   Value of the key
         * @param  string               $key2                    Other Key to search
         * @param  string               $value2                  Other Value of the key
         * @return OfficeCivilRegistry  $myOfficeCivilRegistry   OfficeCivilRegistry result or null
         */
        static function getSingleOfficeCivilRegistry($key = 'id', $value = '', 
                                                     $key2 = '', $value2 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableOfficeCivilReg = DatabaseManager::getNameTable('TABLE_OFFICINE_CIVIL_REGISTRY');

            $query      = "SELECT $tableOfficeCivilReg.*
                           FROM $tableOfficeCivilReg 
                           WHERE $tableOfficeCivilReg.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableOfficeCivilReg.$key2 = '$value2'";
            }

            $myOfficeCivilRegistry    = DatabaseManager::singleFetchAssoc($query);
            $myOfficeCivilRegistry    = self::ArrayToOfficeCivilRegistry($myOfficeCivilRegistry);

            return $myOfficeCivilRegistry;
        }

        /**
         * Recover from database one CivilRegistry object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string          $key               Key to search
         * @param  string          $value             Value of the key
         * @return CivilRegistry   $myCivilRegistry   CivilRegistry result or null
         */
        static function getSingleCivilRegistry($key = 'id', $value  = '', 
                                               $key2 = '',  $value2 = '', 
                                               $key3 = '',  $value3 = '', 
                                               $key4 = '',  $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableCivilRegistry = DatabaseManager::getNameTable('TABLE_CIVIL_REGISTRY');

            $query      = "SELECT $tableCivilRegistry.*
                           FROM $tableCivilRegistry 
                           WHERE $tableCivilRegistry.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . " AND $tableCivilRegistry.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . " AND $tableCivilRegistry.$key3 = '$value3'";
            }
            if ($key4 !== '')
            {
                $query = $query . " AND $tableCivilRegistry.$key4 = '$value4'";
            }

            $myCivilRegistry    = DatabaseManager::singleFetchAssoc($query);
            $myCivilRegistry    = self::ArrayToCivilRegistry($myCivilRegistry);

            return $myCivilRegistry;
        }

        /**
         * Recover from database one BaptismRegistry object
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
         * @return BaptismRegistry   $myBaptismRegistry   BaptismRegistry result or null
         */
        static function getSingleBaptismRegistry($key = 'id', $value = '', 
                                                 $key2 = '', $value2 = '', 
                                                 $key3 = '', $value3 = '', 
                                                 $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableBaptismRegistry = DatabaseManager::getNameTable('TABLE_BAPTISM_REGISTRY');

            $query      = "SELECT $tableBaptismRegistry.*
                           FROM $tableBaptismRegistry 
                           WHERE $tableBaptismRegistry.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . " AND $tableBaptismRegistry.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . " AND $tableBaptismRegistry.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . " AND $tableBaptismRegistry.$key4 = '$value4'";
            }

            $myBaptismRegistry    = DatabaseManager::singleFetchAssoc($query);
            $myBaptismRegistry    = self::ArrayToBaptismRegistry($myBaptismRegistry);

            return $myBaptismRegistry;
        }

        /**
         * Recover from database one Baptism object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string   $key          Key to search
         * @param  string   $value        Value of the key
         * @return Baptism  $baptism      Baptism result or null
         */
        static function getSingleBaptism($key = 'id', $value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableBaptism  = DatabaseManager::getNameTable('TABLE_BAPTISM');

            $query     = "SELECT $tableBaptism.*
                           FROM $tableBaptism 
                           WHERE $tableBaptism.$key = '$value'";

            $baptism      = DatabaseManager::singleFetchAssoc($query);
            $baptism      = self::ArrayToBaptism($baptism);

            return $baptism;
        }

        /**
         * Recover all Baptism from the database begin in one part of the baptism table
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $order       The type of sort of the Baptism
         * @param  integer           $begin       The number of page to display the registry
         * @return Array[Baptism]    $baptisms    Array of Baptism Object
         */
        static function getAllBaptisms($order = 'id', $begin = 0)
        {
            $tableBaptism  = DatabaseManager::getNameTable('TABLE_BAPTISM');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableBaptism.* 
                          FROM $tableBaptism JOIN $tablePerson
                         ON $tableBaptism.idOwner = $tablePerson.id 
                         JOIN $tableChurch 
                         ON $tableBaptism.idChurch = $tableChurch.id";

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
                $query = $query . " ORDER BY $tableBaptism.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayBaptisms = DatabaseManager::multiFetchAssoc($query);
            $baptisms      = array();

            if ($arrayBaptisms !== NULL)
            {
                $i = 0;
                foreach ($arrayBaptisms as $baptism) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $baptisms[] = self::ArrayToBaptism($baptism);
                    $i++;
                }

                return $baptisms;
            }
            else
            {
                return null;
            }
        }

        /**
         * Recover all OfficeCivilRegistry from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[OfficeCivilRegistry]     $officeCivilRegistries   Array of Object
         */
        static function getAllOfficeCivilRegistries()
        {
            $tableOfficeCivilReg  = DatabaseManager::getNameTable('TABLE_OFFICINE_CIVIL_REGISTRY');

            $query     = "SELECT $tableOfficeCivilReg.*
                           FROM $tableOfficeCivilReg";

            $arrayOfficeCivilRegistries = DatabaseManager::multiFetchAssoc($query);
            $officeCivilRegistries      = array();

            foreach ($arrayOfficeCivilRegistries as $officeCivilRegistry) 
            {
                $officeCivilRegistries[] = self::ArrayToOfficeCivilRegistry($officeCivilRegistry);
            }

            return $officeCivilRegistries;
        }

        /**
         * Recover all CivilRegistry from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[CivilRegistry]     $civilRegistries     Array of CivilRegistry Object
         */
        static function getAllCivilRegistries()
        {
            $tableCivilRegistry  = DatabaseManager::getNameTable('TABLE_CIVIL_REGISTRY');

            $query     = "SELECT $tableCivilRegistry.*
                           FROM $tableCivilRegistry";

            $arrayCivilRegistries = DatabaseManager::multiFetchAssoc($query);
            $civilRegistries      = array();

            foreach ($arrayCivilRegistries as $civilRegistry) 
            {
                $civilRegistries[] = self::ArrayToCivilRegistry($civilRegistry);
            }

            return $civilRegistries;
        }

        /**
         * Recover all BaptismRegistry from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[BaptismRegistry]     $baptismRegistries     Array of BaptismRegistry Object
         */
        static function getAllBaptismRegistries()
        {
            $tableBaptismRegistry  = DatabaseManager::getNameTable('TABLE_BAPTISM_REGISTRY');

            $query     = "SELECT $tableBaptismRegistry.*
                           FROM $tableBaptismRegistry
                           ORDER BY book";

            $arrayBaptismRegistries = DatabaseManager::multiFetchAssoc($query);
            $baptismRegistries      = array();

            foreach ($arrayBaptismRegistries as $baptismRegistry) 
            {
                $baptismRegistries[] = self::ArrayToBaptismRegistry($baptismRegistry);
            }

            return $baptismRegistries;
        }

        /**
         * Insert one baptism in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Baptism $baptism  The baptism to insert
         * @return boolean           If was possible to insert
         */
        static function addBaptism($baptism = null)
        {
            if ($baptism === null)
            {
                return false;
            }

            $idOwner       = $baptism->getIdOwner();
            $singleBaptism = self::getSingleBaptism('idOwner', $idOwner);

            if (self::compareBaptism($singleBaptism, $baptism) === false)
            {
                $tableBaptism = DatabaseManager::getNameTable('TABLE_BAPTISM');

                $celebrationDate = $baptism->getCelebrationDate();
                $bornPlace       = $baptism->getBornPlace();
                $bornDate        = $baptism->getBornDate();
                $legitimate      = $baptism->getLegitimate();
                $idGodFather     = $baptism->getIdGodFather();
                $idGodMother     = $baptism->getIdGodMother();
                $idBookRegistry  = $baptism->getIdBookRegistry();
                $idCivilRegistry = $baptism->getIdCivilRegistry();
                $idChurch        = $baptism->getIdChurch();
                $idRector        = $baptism->getIdRector();

                $query     = "INSERT INTO Baptism 
                             (baptismDate,     bornPlace,   bornDate,    legitimate, 
                              idOwner,         idGodMother, idGodFather, idBookRegistry, 
                              idCivilRegistry, idChurch,    idRector) 
                             VALUES 
                             ('$celebrationDate', '$bornPlace',   '$bornDate',    '$legitimate', 
                              '$idOwner',         '$idGodMother', '$idGodFather', '$idBookRegistry', 
                              '$idCivilRegistry', '$idChurch',    '$idRector')";

                if (DatabaseManager::singleAffectedRow($query) === true)
                {
                    $person = PersonManager::getSinglePerson("id", $idOwner);
                    ChangesLogsManager::addChangesLogs("I", "Bautismo de " . $person->getFullNameBeginName());
                    
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else //Baptism Exist
            {
                return false;
            }
        }

        /**
         * Insert one officeCivilRegistry in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  OfficeCivilRegistry $officeCivilRegistry  The officeCivilRegistry to insert
         * @return boolean                                   If was possible to insert
         */
        static function addOfficeCivilRegistry($officeCivilRegistry = null)
        {
            if ($officeCivilRegistry === null)
            {
                return false;
            }

            $idCity = $officeCivilRegistry->getIdCity();
            $number = $officeCivilRegistry->getNumber();
            $single = self::getSingleOfficeCivilRegistry('idCity', $idCity, 'number', $number);

            if (self::compareOfficeCivilRegistry($single, $officeCivilRegistry) === false)
            {
                $tableOfficeCiReg = DatabaseManager::getNameTable('TABLE_OFFICINE_CIVIL_REGISTRY');

                $query     = "INSERT INTO $tableOfficeCiReg
                              (idCity, number)
                              VALUES 
                              ('$idCity', $number)";

                return DatabaseManager::singleAffectedRow($query);
            }
            else
            {
                return false;
            }
        }


        /**
         * Insert one civilRegistry in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  CivilRegistry $civilRegistry  The civilRegistry to insert
         * @return boolean                       If was possible to insert
         */
        static function addCivilRegistry($civilRegistry = null)
        {
            if ($civilRegistry === null)
            {
                return false;
            }

            $number     = $civilRegistry->getNumber();
            $book       = $civilRegistry->getBook();
            $page       = $civilRegistry->getPage();
            $idOfficine = $civilRegistry->getIdOffice();

            $single   = self::getSingleCivilRegistry('number', $number, 
                                                     'book',   $book, 
                                                     'page',   $page, 
                                                     'idOfficineCivilRegistry', $idOfficine);

            if (self::compareCivilRegistry($single, $civilRegistry) === false)
            {
                $tableCivilRegistry = DatabaseManager::getNameTable('TABLE_CIVIL_REGISTRY');

                $query     = "INSERT INTO $tableCivilRegistry
                              (number, book, page, idOfficineCivilRegistry)
                              VALUES 
                              ($number, $book, $page, $idOfficine)";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //CivilRegistry exist
            {
                return false;
            }
        }

        /**
         * Insert one baptismRegistry in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  BaptismRegistry $baptismRegistry  The baptismRegistry to insert
         * @return boolean                           If was possible to insert
         */
        static function addBaptismRegistry($baptismRegistry = null)
        {
            if ($baptismRegistry === null)
            {
                return false;
            }

            $number  = $baptismRegistry->getNumber();
            $book    = $baptismRegistry->getBook();
            $page    = $baptismRegistry->getPage();
            $reverse = $baptismRegistry->getReverse();

            $singleBaptismRegistry = self::getSingleBaptismRegistry('number', $number, 
                                                                    'book', $book, 
                                                                    'page', $page, 
                                                                    'reverse', $reverse);

            if ($singleBaptismRegistry === null)
            {
                $tableBaptismRegistry = DatabaseManager::getNameTable('TABLE_BAPTISM_REGISTRY');

                $query     = "INSERT INTO $tableBaptismRegistry
                              (number, book, page, reverse)
                              VALUES 
                              ('$number', '$book', '$page', '$reverse')";
                
                return DatabaseManager::singleAffectedRow($query);
            }
            else //BaptismRegistry exist
            {
                return false;
            }
        }

        /**
         * Delete one baptism from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Baptism $baptism  The baptism to delete
         * @return boolean           if was possible to delete
         */
        static function removeBaptism($baptism = null)
        {
            if ($baptism === null)
            {
                return false;
            }
            else
            {
                $tableBaptism  = DatabaseManager::getNameTable('TABLE_BAPTISM');
                $id         = $baptism->getId();

                $query     = "DELETE FROM $tableBaptism
                              WHERE $tableBaptism.id = $id";
                
                $person = PersonManager::getSinglePerson("id", $baptism->getIdOwner());                
                ChangesLogsManager::addChangesLogs("D", "Bautismo de " . $person->getFullNameBeginName());
                
                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * Update one baptismRegistry in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Baptism $baptismRegistry  The baptismRegistry to update
         * @return boolean                   if was possible to update
         */
        static function updateBaptismRegistry($baptismRegistry = null)
        {
            if ($baptismRegistry === null)
            {
                return false;
            }

            $tableBaptismRegistry = DatabaseManager::getNameTable('TABLE_BAPTISM_REGISTRY');

            $id              = $baptismRegistry->getId();
            $book            = $baptismRegistry->getBook();
            $page            = $baptismRegistry->getPage();
            $number          = $baptismRegistry->getNumber();

            $query     = "UPDATE $tableBaptismRegistry
                          SET book   = '$book', 
                              page   = '$page', 
                              number = '$number'
                          WHERE $tableBaptismRegistry.id = $id";

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Update one baptism in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Baptism $baptism  The baptism to update
         * @return boolean           if was possible to update
         */
        static function updateBaptism($baptism = null)
        {
            if ($baptism === null)
            {
                return false;
            }

            $tableBaptism = DatabaseManager::getNameTable('TABLE_BAPTISM');

            $id              = $baptism->getId();
            $celebrationDate = $baptism->getCelebrationDate();
            $bornPlace       = $baptism->getBornPlace();
            $bornDate        = $baptism->getBornDate();
            $legitimate      = $baptism->getLegitimate();
            $idGodFather     = $baptism->getIdGodFather();
            $idGodMother     = $baptism->getIdGodMother();
            $idBookRegistry  = $baptism->getIdBookRegistry();
            $idCivilRegistry = $baptism->getIdCivilRegistry();
            $idChurch        = $baptism->getIdChurch();
            $idRector        = $baptism->getIdRector();
            $idOwner         = $baptism->getIdOwner();

            $query     = "UPDATE $tableBaptism
                          SET baptismDate     = '$celebrationDate', 
                              bornPlace       = '$bornPlace', 
                              bornDate        = '$bornDate',        
                              legitimate      = '$legitimate', 
                              idOwner         = '$idOwner',         
                              idGodFather     = '$idGodFather', 
                              idGodMother     = '$idGodMother',     
                              idCivilRegistry = '$idCivilRegistry', 
                              idBookRegistry  = '$idBookRegistry', 
                              idChurch        = '$idChurch', 
                              idRector        = '$idRector' 
                          WHERE $tableBaptism.id = $id";

            $person = PersonManager::getSinglePerson("id", $idOwner);                
            ChangesLogsManager::addChangesLogs("C", "Bautismo de " . $person->getFullNameBeginName());

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Search one baptism by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $string       Necesary string to search
         * @param  string         $order        The type of sort of the Baptism
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Baptism] $baptisms     Baptism objects with the similar name or null
         */
        static function simpleSearchBaptism($string = '', $order = "id", $begin = 0)
        {
            $tableBaptism  = DatabaseManager::getNameTable('TABLE_BAPTISM');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableBaptism.* 
                          FROM $tableBaptism JOIN $tablePerson
                          ON $tableBaptism.idOwner = $tablePerson.id 
                          JOIN $tableChurch 
                          ON $tableBaptism.idChurch = $tableChurch.id
                          WHERE $tablePerson.names     LIKE '%$string%' OR
                                $tablePerson.lastname1 LIKE '%$string%' OR
                                $tablePerson.lastname2 LIKE '%$string%' OR
                                $tableChurch.name      LIKE '%$string%' OR
                                $tableBaptism.id       LIKE '%$string%'";

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
                $query = $query . " ORDER BY $tableBaptism.id";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayBaptisms = DatabaseManager::multiFetchAssoc($query);
            $baptisms      = array();

            if ($arrayBaptisms === NULL)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayBaptisms as $baptism) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $baptisms[] = self::ArrayToBaptism($baptism);
                    $i++;
                }

                return $baptisms;
            }
        }

        /**
         * Search one baptism by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $names      Name(s) of the person to search
         * @param  string         $lastname1  Lastname1 of the person to search
         * @param  string         $lastname2  Lastname2 of the person to search
         * @param  string         $operator   Operator to seach like 'AND' or 'OR'
         * @return Array[Baptism] $baptisms   Baptism objects with the similar name or null
         */
        static function simpleSearchByNames($names     = '', $lastname1 = '', 
                                            $lastname2 = '', $operator  = 'OR')
        {
            if ($names === '')
            {
                return null;
            }

            $lastname1 === '' ? $lastnameA = $names : $lastnameA = $lastname1;
            $lastname2 === '' ? $lastnameB = $names : $lastnameB = $lastname2;

            $tableBaptism = DatabaseManager::getNameTable('TABLE_BAPTISM');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableBaptism.* 
                          FROM $tableBaptism JOIN $tablePerson 
                          ON $tableBaptism.idOwner = $tablePerson.id
                          WHERE $tablePerson.names     = '$names'     $operator
                                $tablePerson.lastname1 = '$lastnameA' $operator
                                $tablePerson.lastname2 = '$lastnameB'";

            $arrayBaptisms = DatabaseManager::multiFetchAssoc($query);

            if ($arrayBaptisms === null)
            {
                return null;
            }
            else
            {
                $baptisms      = array();

                foreach ($arrayBaptisms as $baptism) 
                {
                    $baptisms[] = self::ArrayToBaptism($baptism);
                }

                return $baptisms;
            }
        }

        /**
         * Search one baptism by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Baptism        $baptism      Pseudo-baptism with the data to search
         * @param  string         $operator     To search with 'or' or 'and'
         * @param  string         $order        The type of sort of the Baptism
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Baptism] $baptisms     Baptism objects with the similar name or null
         */
        static function advancedSearchBaptism($baptism = null, $operator = 'AND', 
                                              $order   = 'id', $begin    = 0)
        {
            if ($baptism === null)
            {
                return null;
            }

            $tableBaptism = DatabaseManager::getNameTable('TABLE_BAPTISM');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $celebrationDate = $baptism->getCelebrationDate();
            $bornPlace       = $baptism->getBornPlace();
            $bornDate        = $baptism->getBornDate();
            $queryOwner      = "(";
            $posibleOwner    = $baptism->getIdOwner()[0];
            $queryFather     = "(";
            $posibleFather   = $baptism->getIdOwner()[1];
            $queryMother     = "(";
            $posibleMother   = $baptism->getIdOwner()[2];
            $queryChurch     = "(";
            $posibleChurch   = $baptism->getIdChurch();

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

            if ($baptism->getId() == 0)
            {
                $id = '';
            }
            else
            {
                $id = $baptism->getId();
            }

            if ($baptism->getIdBookRegistry()  == 0)
            {
                $idBookRegistry  = '';
            }
            else
            {
                $idBookRegistry  = $baptism->getIdBookRegistry()->getId();
            }

            $query =   "SELECT b.* 
                        FROM $tableBaptism AS b LEFT JOIN $tablePerson AS o ON b.idOwner = o.id 
                        LEFT JOIN $tablePerson AS fa ON o.idFather = fa.id
                        LEFT JOIN $tablePerson AS mo ON o.idMother = mo.id
                        JOIN $tableChurch AS c  ON b.idChurch = c.id
                        WHERE b.id               LIKE '%$id%'               $operator
                              b.BaptismDate      LIKE '%$celebrationDate%'  $operator
                              b.bornPlace        LIKE '%$bornPlace%'        $operator
                              b.bornDate         LIKE '%$bornDate%'         $operator";

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
                $query = $query . "b.idBookRegistry LIKE '%$idBookRegistry%'";   
            }
            else
            {
                $query = $query . "b.idBookRegistry LIKE '%%'";
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

            $arrayBaptisms = DatabaseManager::multiFetchAssoc($query);
            $baptisms      = array();

            if ($arrayBaptisms !== NULL)
            {
                $i = 0;
                foreach ($arrayBaptisms as $baptism) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $baptisms[] = self::ArrayToBaptism($baptism);
                    $i++;
                }

                return $baptisms;
            }
            else
            {
                return null;
            }
        }
    }
    
 ?>
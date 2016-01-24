<?php 
    
    require_once("Marriage.php");
    require_once("CityManager.php");
    require_once("ChurchManager.php");
    require_once("PersonManager.php");
    require_once("ChangesLogsManager.php");

    /**
    * Class for manipulate Marriage Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class MarriageManager
    {
        /**
         * Transform one Marriage object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Marriage $marriage    marriage object to Transform
         * @return  Array    $marriage    array result for transformation or null
         */
        static function MarriageToArray($marriage = null)
        {
            if ($marriage === null)
            {
                return null;
            }
            else
            {
                $marriageArray = array();

                $marriageArray['id']                  = $marriage->getId();
                $marriageArray['marriageDate']        = $marriage->getCelebrationDate();
                $marriageArray['idBoyfriend']         = $marriage->getIdBoyfriend();
                $marriageArray['idGirlfriend']        = $marriage->getIdGirlfriend();
                $marriageArray['idGodFather']         = $marriage->getIdGodFather();
                $marriageArray['idGodMother']         = $marriage->getIdGodMother();
                $marriageArray['idChurchMarriage']    = $marriage->getIdChurchMarriage();
                $marriageArray['idRector']            = $marriage->getIdRector();
                $marriageArray['idWitness1']          = $marriage->getIdWitness1();
                $marriageArray['idWitness2']          = $marriage->getIdWitness2();
                $marriageArray['idChurchProcess']     = $marriage->getIdChurchProcess();
                $marriageArray['idMarriageRegistry']  = $marriage->getIdBookRegistry();

                return $marriageArray;
            }
        }

        /**
         * Transform one Array object into a Marriage Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array     $marriage   Array object to transform
         * @return  Marriage  $marriage   Marriage result or null
         */
        static function ArrayToMarriage($marriageArray = array())
        {
            if ($marriageArray === null)
            {
                return null;
            }

            $marriage = new Marriage($marriageArray['id'], 
                                     $marriageArray['marriageDate'], 
                                     $marriageArray['idGirlfriend'], 
                                     $marriageArray['idBoyfriend'], 
                                     $marriageArray['idGodFather'], 
                                     $marriageArray['idGodMother'], 
                                     $marriageArray['idWitness1'], 
                                     $marriageArray['idWitness2'], 
                                     $marriageArray['idMarriageRegistry'],
                                     $marriageArray['idChurchMarriage'], 
                                     $marriageArray['idChurchProcess'], 
                                     $marriageArray['idRector']);

            return $marriage;
        }

        /**
         * Transform one MarriageRegistry object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   MarriageRegistry    $marriageRegistry      MarriageRegistry object to transform
         * @return  Array               $array                 Array result or null
         */
        static function MarriageRegistryToArray($marriageRegistry = null)
        {
            if ($marriageRegistry === null)
            {
                return null;
            }

            $array = array();

            $array['id']      = $marriageRegistry->getId();
            $array['book']    = $marriageRegistry->getBook();
            $array['number']  = $marriageRegistry->getNumber();
            $array['page']    = $marriageRegistry->getPage();
            $array['reverse'] = $marriageRegistry->getReverse();

            return $array;
        }

        /**
         * Transform one Array object into a MarriageRegistry Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array               $array                 Array object to transform
         * @return  MarriageRegistry    $marriageRegistry      MarriageRegistry result or null
         */
        static function ArrayToMarriageRegistry($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $marriageRegistry = new MarriageRegistry($array['id'], $array['book'], $array['number'], 
                                                   $array['page'], $array['reverse']);
            return $marriageRegistry;
        }

        /**
         * Return if two marriage objects are equals
         * 
         * @param  Marriage     $marriage1 Marriage 1
         * @param  Marriage     $marriage2 Marriage 2
         * @return boolean         result
         */
        static function compareMarriage($marriage1 = null, $marriage2 = null)
        {
            if ($marriage1 === null || $marriage2 === null)
            {
                return false;
            }
            else
            {
                if (($marriage1->getIdBoyfriend()  == $marriage2->getIdBoyfriend())   &&
                    ($marriage1->getIdGirlfriend() == $marriage2->getIdGirlfriend()))
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
         * Return if two marriageRegistry objects are equals
         * 
         * @param  MarriageRegistry     $marriageRegistry1   MarriageRegistry 1
         * @param  MarriageRegistry     $marriageRegistry2   MarriageRegistry 2
         * @return boolean             result
         */
        static function compareMarriageRegistry($marriageRegistry1 = null,$marriageRegistry2 = null)
        {
            if ($marriageRegistry1 === null || $marriageRegistry2 === null)
            {
                return false;
            }
            else
            {
                if (($marriageRegistry1->getBook()    == $marriageRegistry2->getBook())    &&
                    ($marriageRegistry1->getNumber()  == $marriageRegistry2->getNumber())  &&
                    ($marriageRegistry1->getReverse() == $marriageRegistry2->getReverse()) &&
                    ($marriageRegistry1->getPage()    == $marriageRegistry2->getPage()))
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
         * Recover from database one MarriageRegistry object
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
         * @return MarriageRegistry   $myMarriageRegistry   marriageRegistry result or null
         */
        static function getSingleMarriageRegistry($key = 'id', $value = '', 
                                                  $key2 = '', $value2 = '', 
                                                  $key3 = '', $value3 = '', 
                                                  $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableMarriageRegistry = DatabaseManager::getNameTable('TABLE_MARRIAGE_REGISTRY');

            $query      = "SELECT $tableMarriageRegistry.*
                           FROM $tableMarriageRegistry 
                           WHERE $tableMarriageRegistry.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableMarriageRegistry.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tableMarriageRegistry.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $tableMarriageRegistry.$key4 = '$value4'";
            }

            $myMarriageRegistry    = DatabaseManager::singleFetchAssoc($query);
            $myMarriageRegistry    = self::ArrayToMarriageRegistry($myMarriageRegistry);

            return $myMarriageRegistry;
        }

        /**
         * Recover from database one Marriage object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       key to search
         * @param  string  $value     value of the key
         * @return Marriage  $marriage      Marriage result or null
         */
        static function getSingleMarriage($key = 'id', $value = '', $key2 = '', $value2 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableMarriage  = DatabaseManager::getNameTable('TABLE_MARRIAGE');

            $query     = "SELECT $tableMarriage.*
                           FROM $tableMarriage 
                           WHERE $tableMarriage.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableMarriage.$key2 = '$value2'";
            }

            $marriage      = DatabaseManager::singleFetchAssoc($query);
            $marriage      = self::ArrayToMarriage($marriage);

            return $marriage;
        }

        /**
         * Recover all Marriage from the database begin in one part of the marriage table
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $order       The type of sort of the Marriage
         * @param  integer           $begin       The number of page to display the registry
         * @return Array[Marriage]    $marriages    Array of Marriage Object
         */
        static function getAllMarriages($order = 'id', $begin = 0)
        {
            $tableMarriage  = DatabaseManager::getNameTable('TABLE_MARRIAGE');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query    = "SELECT m.* 
                         FROM $tableMarriage AS m JOIN $tablePerson AS b ON m.idBoyfriend = b.id 
                         JOIN $tablePerson AS g ON m.idGirlfriend = g.id
                         JOIN $tableChurch AS c  ON m.idChurchMarriage = c.id";

            if ($order == 'nameBoy')
            {
                $query = $query . " ORDER BY b.lastname1";
            }
            else if ($order == 'nameGirl')
            {
                $query = $query . " ORDER BY g.lastname1";
            }
            else if ($order == 'church')
            {
                $query = $query . " ORDER BY c.name";
            }
            else
            {
                $query = $query . " ORDER BY m.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayMarriages = DatabaseManager::multiFetchAssoc($query);
            $marriages      = array();

            if ($arrayMarriages !== NULL)
            {
                $i = 0;
                foreach ($arrayMarriages as $marriage) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $marriages[] = self::ArrayToMarriage($marriage);
                    $i++;
                }

                return $marriages;
            }
            else
            {
                return null;
            }
        }

        /**
         * Recover all MarriageRegistry from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[MarriageRegistry]   $marriageRegistries   Array of MarriageRegistry Object
         */
        static function getAllMarriageRegistries()
        {
            $tableMarriageRegistry  = DatabaseManager::getNameTable('TABLE_MARRIAGE_REGISTRY');

            $query     = "SELECT $tableMarriageRegistry.*
                           FROM $tableMarriageRegistry
                           ORDER BY book";

            $arrayMarriageRegistries = DatabaseManager::multiFetchAssoc($query);
            $marriageRegistries      = array();

            foreach ($arrayMarriageRegistries as $marriageRegistry) 
            {
                $marriageRegistries[] = self::ArrayToMarriageRegistry($marriageRegistry);
            }

            return $marriageRegistries;
        }

        /**
         * insert one marriage in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Marriage $marriage  The marriage to insert
         * @return boolean           If was possible to insert
         */
        static function addMarriage($marriage = null)
        {
            if ($marriage === null)
            {
                return false;
            }

            $idBoyfriend         = $marriage->getIdBoyfriend();
            $idGirlfriend        = $marriage->getIdGirlfriend();

            $singleMarriage = self::getSingleMarriage('idGirlfriend', $idGirlfriend, 
                                                      'idBoyfriend', $idBoyfriend);

            if (self::compareMarriage($singleMarriage, $marriage) === false)
            {
                $tableMarriage = DatabaseManager::getNameTable('TABLE_MARRIAGE');

                $id                  = $marriage->getId();
                $marriageDate        = $marriage->getCelebrationDate();
                $idGodFather         = $marriage->getIdGodFather();
                $idGodMother         = $marriage->getIdGodMother();
                $idChurchMarriage    = $marriage->getIdChurchMarriage();
                $idRector            = $marriage->getIdRector();
                $idWitness1          = $marriage->getIdWitness1();
                $idWitness2          = $marriage->getIdWitness2();
                $idChurchProcess     = $marriage->getIdChurchProcess();
                $idMarriageRegistry  = $marriage->getIdBookRegistry();

                $query     = "INSERT INTO Marriage 
                             (marriageDate, idBoyfriend,      idGirlfriend,       idGodFather, 
                              idGodMother,  idChurchMarriage, idRector,           idWitness1, 
                              idWitness2,   idChurchProcess,  idMarriageRegistry) 
                             VALUES 
                             ('$marriageDate', '$idBoyfriend',      '$idGirlfriend', '$idGodFather', 
                              '$idGodMother',  '$idChurchMarriage', '$idRector',     '$idWitness1', 
                              '$idWitness2',   '$idChurchProcess',  '$idMarriageRegistry')"; 

                $personA = PersonManager::getSinglePerson("id", $idBoyfriend);
                $personB = PersonManager::getSinglePerson("id", $idGirlfriend);
                ChangesLogsManager::addChangesLogs("I", "Matrimonio de" . $personA->getFullNameBeginName() . " y " .  $personB->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
            else //Marriage Exist
            {
                return false;
            }
        }

        /**
         * insert one marriageRegistry in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  MarriageRegistry $marriageRegistry  The marriageRegistry to insert
         * @return boolean       If was possible to insert
         */
        static function addMarriageRegistry($marriageRegistry = null)
        {
            if ($marriageRegistry === null)
            {
                return false;
            }

            $number  = $marriageRegistry->getNumber();
            $book    = $marriageRegistry->getBook();
            $page    = $marriageRegistry->getPage();
            $reverse = $marriageRegistry->getReverse();

            $singleMarriageRegistry = self::getSingleMarriageRegistry('number', $number, 
                                                                      'book', $book, 
                                                                      'page', $page, 
                                                                      'reverse', $reverse);

            if ($singleMarriageRegistry === null)
            {
                $tableMarriageRegistry = DatabaseManager::getNameTable('TABLE_MARRIAGE_REGISTRY');

                $query     = "INSERT INTO $tableMarriageRegistry
                              (number, book, page, reverse)
                              VALUES 
                              ('$number', '$book', '$page', '$reverse')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //MarriageRegistry exist
            {
                return false;
            }
        }

        /**
         * delete one marriage from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Marriage $marriage  The marriage to delete
         * @return boolean     if was possible to delete
         */
        static function removeMarriage($marriage = null)
        {
            if ($marriage === null)
            {
                return false;
            }
            else
            {
                $tableMarriage  = DatabaseManager::getNameTable('TABLE_MARRIAGE');
                $id         = $marriage->getId();

                $query     = "DELETE FROM $tableMarriage
                              WHERE $tableMarriage.id = $id";

                $personA = PersonManager::getSinglePerson("id", $marriage->getIdBoyfriend());
                $personB = PersonManager::getSinglePerson("id", $marriage->getIdGirlfriend());
                ChangesLogsManager::addChangesLogs("D", "Matrimonio de" . $personA->getFullNameBeginName() . " y " .  $personB->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * update one marriage in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Marriage $marriage  The marriage to update
         * @return boolean     if was possible to update
         */
        static function updateMarriage($marriage = null)
        {
            if ($marriage === null)
            {
                return false;
            }

            $tableMarriage = DatabaseManager::getNameTable('TABLE_MARRIAGE');

            $idBoyfriend         = $marriage->getIdBoyfriend();
            $idGirlfriend        = $marriage->getIdGirlfriend();
            $id                  = $marriage->getId();
            $marriageDate        = $marriage->getCelebrationDate();
            $idGodFather         = $marriage->getIdGodFather();
            $idGodMother         = $marriage->getIdGodMother();
            $idChurchMarriage    = $marriage->getIdChurchMarriage();
            $idRector            = $marriage->getIdRector();
            $idWitness1          = $marriage->getIdWitness1();
            $idWitness2          = $marriage->getIdWitness2();
            $idChurchProcess     = $marriage->getIdChurchProcess();
            $idMarriageRegistry  = $marriage->getIdBookRegistry();

            $query     = "UPDATE $tableMarriage
                          SET idBoyfriend        = '$idBoyfriend', 
                              idGirlfriend       = '$idGirlfriend', 
                              idGodFather        = '$idGodFather', 
                              idGodMother        = '$idGodMother', 
                              idWitness1         = '$idWitness1', 
                              idWitness2         = '$idWitness2',
                              idMarriageRegistry = '$idMarriageRegistry', 
                              idChurchProcess    = '$idChurchProcess', 
                              idRector           = '$idRector', 
                              idChurchMarriage   = '$idChurchMarriage', 
                              marriageDate       = '$marriageDate'
                          WHERE $tableMarriage.id = $id";

            $personA = PersonManager::getSinglePerson("id", $idBoyfriend);
            $personB = PersonManager::getSinglePerson("id", $idGirlfriend);
            ChangesLogsManager::addChangesLogs("C", "Matrimonio de" . $personA->getFullNameBeginName() . " y " .  $personB->getFullNameBeginName());

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Search one marriage by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $string       Necesary string to search
         * @param  string         $order        The type of sort of the Marriage
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Marriage] $marriages     Marriage objects with the similar name or null
         */
        static function simpleSearchMarriage($string = '', $order = "id", $begin = 0)
        {
            $tableMarriage  = DatabaseManager::getNameTable('TABLE_MARRIAGE');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query    = "SELECT m.* 
                         FROM $tableMarriage AS m JOIN $tablePerson AS b ON m.idBoyfriend = b.id 
                         JOIN $tablePerson AS g ON m.idGirlfriend = g.id
                         JOIN $tableChurch AS c  ON m.idChurchMarriage = c.id
                         WHERE b.names     LIKE '%$string%' OR
                               b.lastname1 LIKE '%$string%' OR
                               b.lastname2 LIKE '%$string%' OR
                               g.names     LIKE '%$string%' OR
                               g.lastname1 LIKE '%$string%' OR
                               g.lastname2 LIKE '%$string%' OR
                               c.name      LIKE '%$string%' OR
                               m.id        LIKE '%$string%'";

            if ($order == 'nameBoy')
            {
                $query = $query . " ORDER BY b.lastname1";
            }
            else if ($order == 'nameGirl')
            {
                $query = $query . " ORDER BY g.lastname1";
            }
            else if ($order == 'nameChurch')
            {
                $query = $query . " ORDER BY c.name";
            }
            else
            {
                $query = $query . " ORDER BY m.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayMarriages = DatabaseManager::multiFetchAssoc($query);
            $marriages      = array();

            if ($arrayMarriages === NULL)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayMarriages as $marriage) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $marriages[] = self::ArrayToMarriage($marriage);
                    $i++;
                }

                return $marriages;
            }
        }

        /**
         * search one marriage by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $key        element for join tables
         * @param  string         $names      name of the person to search
         * @param  string         $lastname1  lastname1 of the person to search
         * @param  string         $lastname2  lastname2 of the person to search
         * @param  string         $operator   operator to seach like 'AND' or 'OR'
         * @return Array[Marriage] $marriages     Marriage objects with the similar name or null
         */
        static function simpleSearchByNames($key = 'idBoyfriend', $names = '', $lastname1 = '', 
                                            $lastname2 = '',      $operator = 'OR')
        {
            if ($names === '')
            {
                return null;
            }

            $lastname1 === '' ? $lastnameA = $names : $lastnameA = $lastname1;
            $lastname2 === '' ? $lastnameB = $names : $lastnameB = $lastname2;

            $tableMarriage = DatabaseManager::getNameTable('TABLE_MARRIAGE');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableMarriage.* 
                          FROM $tableMarriage JOIN $tablePerson 
                          ON $tableMarriage.$key = $tablePerson.id
                          WHERE $tablePerson.names     = '$names'     $operator
                                $tablePerson.lastname1 = '$lastnameA' $operator
                                $tablePerson.lastname2 = '$lastnameB'";

            $arrayMarriages = DatabaseManager::multiFetchAssoc($query);

            if ($arrayMarriages === null)
            {
                return null;
            }
            else
            {
                $marriages = array();

                foreach ($arrayMarriages as $marriage) 
                {
                    $marriages[] = self::ArrayToMarriage($marriage);
                }

                return $marriages;
            }
        }

        /**
         * Search one marriage by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Marriage        $marriage    Pseudo-marriage with the data to search
         * @param  string         $operator     To search with 'or' or 'and'
         * @param  string         $order        The type of sort of the Marriage
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Marriage] $marriages   Marriage objects with the similar name or null
         */
        static function advancedSearchMarriage($marriage = null, $operator = 'AND', 
                                               $order = 'id',    $begin = 0)
        {
            if ($marriage === null)
            {
                return null;
            }

            $tableMarriage = DatabaseManager::getNameTable('TABLE_MARRIAGE');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');

            $celebrationDate = $marriage->getCelebrationDate();
            $queryBoy        = "(";
            $posibleBoy      = $marriage->getIdBoyfriend();
            $queryGirl       = "(";
            $posibleGirl     = $marriage->getIdGirlfriend();
            $queryChurch     = "(";
            $posibleChurch   = $marriage->getIdChurchMarriage();

            if ($posibleBoy !== NULL) //If exist boyfriend id
            {
                for ($i = 0; $i < sizeof($posibleBoy) - 1; $i++)
                {
                    $queryBoy = $queryBoy . $posibleBoy[$i]->getId() . ",";
                }

                $queryBoy  = $queryBoy . $posibleBoy[sizeof($posibleBoy)-1]->getId(). ")";
                $queryBoy  = "((b.id IN " . $queryBoy . ") OR b.id IS NULL)";
            }

            if ($posibleGirl !== NULL) //If exist girlfriend id
            {
                for ($i = 0; $i < sizeof($posibleGirl) - 1; $i++)
                {
                    $queryGirl = $queryGirl . $posibleGirl[$i]->getId() . ",";
                }
    
                $queryGirl  = $queryGirl . $posibleGirl[sizeof($posibleGirl)-1]->getId(). ")";
                $queryGirl  = "((g.id IN " . $queryGirl . ") OR g.id IS NULL)";
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

            if ($marriage->getId() == 0)
            {
                $id = ''; 
            }
            else
            {
                $id = $marriage->getId();
            }

            if ($marriage->getIdBookRegistry() == 0)
            {
                $idBookRegistry  = '';
            }
            else
            {
                $idBookRegistry  = $marriage->getIdBookRegistry()->getId();
            }

            $query =   "SELECT m.* 
                        FROM $tableMarriage AS m 
                        LEFT JOIN $tablePerson AS b ON m.idBoyfriend = b.id
                        LEFT JOIN $tablePerson AS g ON m.idGirlfriend = g.id
                        JOIN $tableChurch AS c  ON m.idChurchMarriage = c.id
                        WHERE m.id               LIKE '%$id%'               $operator
                              m.marriageDate     LIKE '%$celebrationDate%'  $operator ";

            //Join the Query with the posibiitation query
            if ($queryBoy != '(')
            {
                $query = $query . $queryBoy . " " . $operator. " ";
            }
            else
            {
                $query = $query . "(b.id IN ())" . $operator. " ";
            }

            if ($queryGirl != '(')
            {
                $query = $query . $queryGirl . " " . $operator. " ";
            }
            else
            {
                $query = $query . "(g.id IN ())" . $operator. " ";
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
                $query = $query . "m.idMarriageRegistry LIKE '%$idBookRegistry%'";   
            }
            else
            {
                $query = $query . "m.idMarriageRegistry LIKE '%%'";
            }

            if ($order == 'nameBoy')
            {
                $query = $query . " ORDER BY b.lastname1";
            }
            else if ($order == 'nameGirl')
            {
                $query = $query . " ORDER BY g.lastname1";
            }
            else if ($order == 'nameChurch')
            {
                $query = $query . " ORDER BY c.name";
            }
            else
            {
                $query = $query . " ORDER BY m.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayMarriages = DatabaseManager::multiFetchAssoc($query);
            $marriages      = array();

            if ($arrayMarriages !== NULL)
            {
                $i = 0;
                foreach ($arrayMarriages as $marriage) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $marriages[] = self::ArrayToMarriage($marriage);
                    $i++;
                }

                return $marriages;
            }
            else
            {
                return null;
            }
        }
    }


 ?>
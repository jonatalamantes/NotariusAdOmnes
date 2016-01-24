<?php 
    
    require_once("ProofTalks.php");
    require_once("DatabaseManager.php");
    require_once("PersonManager.php");
    require_once("ChurchManager.php");
    require_once("ChangesLogsManager.php");

    /**
    * Clas for manipulate ProofTalks Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ProofManager
    {
        /**
         * Transform one ProofTalks object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   ProofTalks  $ProofTalks       ProofTalks object to Transform
         * @return  Array       $ProofTalksArray  array result for transformation or null
         */
        static function ProofTalksToArray($ProofTalks = null)
        {
            if ($ProofTalks === null)
            {
                return null;
            }
            else
            {
                $ProofTalksArray = array();

                $ProofTalksArray['id']          = $ProofTalks->getId(); 
                $ProofTalksArray['idOwner']     = $ProofTalks->getIdOwner();
                $ProofTalksArray['idGodFather'] = $ProofTalks->getIdGodFather();
                $ProofTalksArray['idGodMother'] = $ProofTalks->getIdGodMother();
                $ProofTalksArray['idChurch']    = $ProofTalks->getIdChurch();
                $ProofTalksArray['type']        = $ProofTalks->getType();

                return $ProofTalksArray;
            }
        }

        /**
         * Transform one Array object into a ProofTalks Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array         $array          Array object to transform
         * @return  ProofTalks    $ProofTalks     ProofTalks result or null
         */
        static function ArrayToProofTalks($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $ProofTalks  = new ProofTalks($array['id'],          $array['idOwner'], 
                                          $array['idGodFather'], $array['idGodMother'],
                                          $array['idChurch'],    $array['type']);

            return $ProofTalks;
        }

        /**
         * Return if two ProofTalks objects are equals
         * 
         * @param  ProofTalks     $ProofTalks1 ProofTalks 1
         * @param  ProofTalks     $ProofTalks2 ProofTalks 2
         * @return boolean    result
         */
        static function compareProofTalks($ProofTalks1 = null, $ProofTalks2 = null)
        {
            if ($ProofTalks1 === null || $ProofTalks2 === null)
            {
                return false;
            }
            else
            {
                if (($ProofTalks1->getIdOwner() == $ProofTalks2->getIdOwner()) &&
                    ($ProofTalks1->getType()    == $ProofTalks2->getType()))
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
         * Recover from database one ProofTalks object by id
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
         * @return ProofTalks  $myProofTalks   proofTalks result or null
         */
        static function getSingleProofTalks($key = 'id', $value = 0, 
                                            $key2 = '', $value2 = '', 
                                            $key3 = '', $value3 = '', 
                                            $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableProofTalks = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');

            $query      = "SELECT $tableProofTalks.*
                           FROM $tableProofTalks 
                           WHERE $tableProofTalks.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableProofTalks.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tableProofTalks.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $tableProofTalks.$key4 = '$value4'";
            }

            $myProofTalks    = DatabaseManager::singleFetchAssoc($query);
            $myProofTalks    = self::ArrayToProofTalks($myProofTalks);

            return $myProofTalks;
        }

        /**
         * Recover all Proof from the database begin in one part of the proof table
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $order       The type of sort of the Proof
         * @param  integer           $begin       The number of page to display the registry
         * @return Array[Proof]    $proofs    Array of Proof Object
         */
        static function getAllProofs($order = 'id', $begin = 0)
        {
            $tableProof  = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableProof.* 
                          FROM $tableProof JOIN $tablePerson
                         ON $tableProof.idOwner = $tablePerson.id 
                         JOIN $tableChurch 
                         ON $tableProof.idChurch = $tableChurch.id";

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
                $query = $query . " ORDER BY $tableProof.id DESC";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayProofs = DatabaseManager::multiFetchAssoc($query);
            $proofs      = array();

            if ($arrayProofs !== NULL)
            {
                $i = 0;
                foreach ($arrayProofs as $proof) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $proofs[] = self::ArrayToProofTalks($proof);
                    $i++;
                }

                return $proofs;
            }
            else
            {
                return null;
            }
        }

        /**
         * insert one ProofTalks in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  ProofTalks $ProofTalks  The ProofTalks to insert
         * @return boolean         If was posible to insert
         */
        static function addProofTalks($ProofTalks = null)
        {
            if ($ProofTalks === null)
            {
                return false;
            }

            $idOwner     = $ProofTalks->getIdOwner();
            $type        = $ProofTalks->getType();

            $singleProofTalks  = self::getSingleProofTalks('idOwner', $idOwner, 'type', $type);

            if (self::compareProofTalks($singleProofTalks, $ProofTalks) === false)
            {
                $tableProofTalks   = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');

                $id          = $ProofTalks->getId(); 
                $idGodFather = $ProofTalks->getIdGodFather();
                $idGodMother = $ProofTalks->getIdGodMother();
                $idChurch    = $ProofTalks->getIdChurch();

                if ($idGodFather === NULL)
                {
                    $idGodFather = 'NULL';
                }

                if ($idGodMother === NULL)
                {
                    $idGodMother = 'NULL';
                }

                $query     = "INSERT INTO $tableProofTalks
                              (idOwner, idGodFather, idGodMother, idChurch, type)
                              VALUES 
                              ('$idOwner', $idGodFather, $idGodMother, '$idChurch', '$type')";

                $person = PersonManager::getSinglePerson("id", $idOwner);
                ChangesLogsManager::addChangesLogs("I", "Comprobante de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
            else //ProofTalks Exist
            {
                return false;
            }
        }

        /**
         * Recover the last ID from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return integer         The last id on the database
         */
        static function getLastID()
        {
            $tableProofTalks  = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');

            $query     = "SELECT MAX(id) AS Max FROM $tableProofTalks";

            return DatabaseManager::singleFetchAsoc($query)["Max"];
        }

        /**
         * delete one ProofTalks from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  ProofTalks $ProofTalks  The ProofTalks to delete
         * @return boolean         If was posible to delete
         */
        static function removeProofTalks($ProofTalks = null)
        {
            if ($ProofTalks === null)
            {
                return false;
            }
            else
            {
                $tableProofTalks  = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');
                $id         = $ProofTalks->getId();

                $query     = "DELETE FROM $tableProofTalks
                              WHERE $tableProofTalks.id = $id";

                $person = PersonManager::getSinglePerson("id", $ProofTalks->getIdOwner());
                ChangesLogsManager::addChangesLogs("D", "Comprobante de " . $person->getFullNameBeginName());

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * update one ProofTalks in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  ProofTalks $ProofTalks  The ProofTalks to update
         * @return boolean         If was posible to update
         */
        static function updateProofTalks($ProofTalks = null)
        {
            if ($ProofTalks === null)
            {
                return false;
            }

            $tableProofTalks = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');

            $idOwner     = $ProofTalks->getIdOwner();
            $type        = $ProofTalks->getType();
            $id          = $ProofTalks->getId(); 
            $idGodFather = $ProofTalks->getIdGodFather();
            $idGodMother = $ProofTalks->getIdGodMother();
            $idChurch    = $ProofTalks->getIdChurch();

            if ($idGodFather === NULL)
            {
                $idGodFather = 'NULL';
            }

            if ($idGodMother === NULL)
            {
                $idGodMother = 'NULL';
            }

            $query     = "UPDATE $tableProofTalks
                          SET idOwner = '$idOwner', type = '$type', idGodMother = $idGodMother, 
                              idGodFather = $idGodFather, idChurch = '$idChurch'
                          WHERE $tableProofTalks.id = $id";

            $person = PersonManager::getSinglePerson("id", $idOwner);
            ChangesLogsManager::addChangesLogs("C", "Comprobante de " . $person->getFullNameBeginName());

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Search one proof by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $string       Necesary string to search
         * @param  string         $order        The type of sort of the Proof
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Proof] $proofs     Proof objects with the similar name or null
         */
        static function simpleSearchProof($string = '', $order = "id", $begin = 0)
        {
            $tableProof  = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');
            $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tableProof.* 
                          FROM $tableProof JOIN $tablePerson
                          ON $tableProof.idOwner = $tablePerson.id 
                          JOIN $tableChurch 
                          ON $tableProof.idChurch = $tableChurch.id
                          WHERE $tablePerson.names     LIKE '%$string%' OR
                                $tablePerson.lastname1 LIKE '%$string%' OR
                                $tablePerson.lastname2 LIKE '%$string%' OR
                                $tableChurch.name      LIKE '%$string%' OR
                                $tableProof.id       LIKE '%$string%'";

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
                $query = $query . " ORDER BY $tableProof.id";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayProofs = DatabaseManager::multiFetchAssoc($query);
            $proofs      = array();

            if ($arrayProofs === NULL)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayProofs as $proof) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $proofs[] = self::ArrayToProofTalks($proof);
                    $i++;
                }

                return $proofs;
            }
        }

        /**
         * Search one proof by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Proof        $proof      Pseudo-proof with the data to search
         * @param  string         $operator     To search with 'or' or 'and'
         * @param  string         $order        The type of sort of the Proof
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[Proof] $proofs     Proof objects with the similar name or null
         */
        static function advancedSearchProof($proof = null, $operator = 'AND', 
                                            $order = 'id', $begin = 0)
        {
            if ($proof === null)
            {
                return null;
            }

            $tableProof = DatabaseManager::getNameTable('TABLE_PROFF_TALKS');
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $queryOwner      = "(";
            $posibleOwner    = $proof->getIdOwner()[0];
            $queryFather     = "(";
            $posibleFather   = $proof->getIdOwner()[1];
            $queryMother     = "(";
            $posibleMother   = $proof->getIdOwner()[2];
            $queryChurch     = "(";
            $posibleChurch   = $proof->getIdChurch();

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

            $typeProof = "'%%'";

            if ($proof->getType() == '1')
            {
                $typeProof = "'B'";
            }
            else if ($proof->getType() == '2')
            {
                $typeProof = "'E'";
            }
            else if ($proof->getType() == '3')
            {
                $typeProof = "'C'";
            }
            else if ($proof->getType() == '4')
            {
                $typeProof = "'X'";
            }

            $query =   "SELECT b.* 
                        FROM $tableProof AS b LEFT JOIN $tablePerson AS o ON b.idOwner = o.id 
                        LEFT JOIN $tablePerson AS fa ON o.idFather = fa.id
                        LEFT JOIN $tablePerson AS mo ON o.idMother = mo.id
                        JOIN $tableChurch AS c  ON b.idChurch = c.id
                        WHERE b.type LIKE $typeProof $operator ";

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

            $arrayProofs = DatabaseManager::multiFetchAssoc($query);
            $proofs      = array();

            if ($arrayProofs !== NULL)
            {
                $i = 0;
                foreach ($arrayProofs as $proof) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $proofs[] = self::ArrayToProofTalks($proof);
                    $i++;
                }

                return $proofs;
            }
            else
            {
                return null;
            }
        }        
    }
        
 ?>
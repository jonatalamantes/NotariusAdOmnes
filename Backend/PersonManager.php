<?php 
    
    require_once("Person.php");
    require_once("DatabaseManager.php");

    /**
    * Class for manipulate Person Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class PersonManager
    {
        /**
         * Transform one Person object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Person  $Person       Person object to Transform
         * @return  Array   $PersonArray  Array result for transformation or null
         */
        static function PersonToArray($Person = null)
        {
            if ($Person === null)
            {
                return null;
            }
            else
            {
                $PersonArray = array();

                $PersonArray['id']            = $Person->getId(); 
                $PersonArray['names']         = $Person->getNames();
                $PersonArray['lastname1']     = $Person->getLastname1();
                $PersonArray['lastname2']     = $Person->getLastname2();
                $PersonArray['gender']        = $Person->getGender();
                $PersonArray['address']       = $Person->getAddress();
                $PersonArray['phoneNumber']   = $Person->getPhoneNumber();
                $PersonArray['idFather']      = $Person->getIdFather();
                $PersonArray['idMother']      = $Person->getIdMother();
                $PersonArray['idCityAddress'] = $Person->getIdCityAddress();

                return $PersonArray;
            }
        }

        /**
         * Transform one Array object into a Person Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array     $array      Array object to transform
         * @return  Person    $Person     Person result or null
         */
        static function ArrayToPerson($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $Person  = new Person($array['id'],          $array['names'], 
                                  $array['lastname1'],   $array['lastname2'],
                                  $array['gender'],      $array['address'], 
                                  $array['phoneNumber'], $array['idFather'],
                                  $array['idMother'],    $array['idCityAddress']);

            return $Person;
        }

        /**
         * Return if two Person objects are equals
         * 
         * @param  Person     $Person1 Person 1
         * @param  Person     $Person2 Person 2
         * @return boolean             Result
         */
        static function comparePerson($Person1 = null, $Person2 = null)
        {
            if ($Person1 === null || $Person2 === null)
            {
                return false;
            }
            else
            {
                if (($Person1->getNames()     == $Person2->getNames())     &&
                    ($Person1->getLastname1() == $Person2->getLastname1()) &&
                    ($Person1->getLastname2() == $Person2->getLastname2()) &&
                    ($Person1->getAddress()   == $Person2->getAddress()))
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
         * Recover from database one Person object by id
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
         * @return Person  $myPerson    Person result or null
         */
        static function getSinglePerson($key = 'id', $value = 0, 
                                        $key2 = '', $value2 = '', 
                                        $key3 = '', $value3 = '', 
                                        $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tablePerson = DatabaseManager::getNameTable('TABLE_PERSON');

            $query      = "SELECT $tablePerson.*
                           FROM $tablePerson 
                           WHERE $tablePerson.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tablePerson.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tablePerson.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $tablePerson.$key4 = '$value4'";
            }

            $myPerson    = DatabaseManager::singleFetchAssoc($query);
            $myPerson    = self::ArrayToPerson($myPerson);

            return $myPerson;
        }

        /**
         * Recover all Person from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[Person]   $persons     Array of Person Object
         */
        static function getAllPersons()
        {
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tablePerson.*
                          FROM $tablePerson";

            $arrayPersons = DatabaseManager::multiFetchAssoc($query);
            $persons      = array();

            if ($arrayPersons === null)
            {
                return null;
            }

            foreach ($arrayPersons as $Person) 
            {
                $persons[] = self::ArrayToPerson($Person);
            }

            return $persons;
        }

        /**
         * Insert one Person in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Person    $Person   The Person to insert
         * @param  string    $force    Force to insert one object in the database
         * @return boolean             If was possible to insert
         */
        static function addPerson($Person = null, $force = 'false')
        {
            if ($Person === null)
            {
                return false;
            }

            $names         = $Person->getNames();
            $lastname1     = $Person->getLastname1();
            $lastname2     = $Person->getLastname2();
            $address       = $Person->getAddress();

            $names         = $Person->getNames();
            $singlePerson  = self::getSinglePerson('names', $names, 
                                                   'lastname1', $lastname1, 
                                                   'lastname2', $lastname2, 
                                                   'address', $address);
            $next = true;

            if (!$force)
            {
                $next = self::comparePerson($singlePerson, $Person) === false;
            }

            if ($next)
            {
                $tablePerson   = DatabaseManager::getNameTable('TABLE_PERSON');
                $gender        = $Person->getGender();
                $phoneNumber   = $Person->getPhoneNumber();

                if ($Person->getIdFather() == 0)
                {
                    $idFather = 'null'; 
                }
                else
                {
                    $idFather = $Person->getIdFather();
                }

                if ($Person->getIdMother() == 0)
                {
                    $idMother = 'null'; 
                }
                else
                {
                    $idMother = $Person->getIdMother();
                }

                if ($Person->getIdCityAddress() == 0)
                {
                    $idCityAddress = 'null'; 
                }
                else
                {
                    $idCityAddress = $Person->getIdCityAddress();
                }

                $query     = "INSERT INTO $tablePerson
                              (names,         lastname1,   lastname2, gender, 
                               address,       phoneNumber, idFather,  idMother, 
                               idCityAddress)
                              VALUES 
                              ('$names',   '$lastname1',  '$lastname2', '$gender', 
                               '$address', '$phoneNumber', $idFather,    $idMother, 
                                $idCityAddress)";
                
                return DatabaseManager::singleAffectedRow($query);
            }
            else //Person Exist
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
            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT MAX(id) AS Max FROM $tablePerson";

            return DatabaseManager::singleFetchAssoc($query)["Max"];
        }

        /**
         * Delete one Person from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Person   $Person  The Person to delete
         * @return boolean           If was possible to delete
         */
        static function removePerson($Person = null)
        {
            if ($Person === null)
            {
                return false;
            }
            else
            {
                $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');
                $id         = $Person->getId();

                $query     = "DELETE FROM $tablePerson
                              WHERE $tablePerson.id = $id";

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * Update one Person in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Person    $Person  The Person to update
         * @return boolean            If was possible to update
         */
        static function updatePerson($Person = null)
        {
            if ($Person === null)
            {
                return false;
            }

            $tablePerson = DatabaseManager::getNameTable('TABLE_PERSON');
            $id            = $Person->getId();
            $names         = $Person->getNames();
            $lastname1     = $Person->getLastname1();
            $lastname2     = $Person->getLastname2();
            $gender        = $Person->getGender();
            $address       = $Person->getAddress();
            $phoneNumber   = $Person->getPhoneNumber();
            $Person->getIdFather() == 0 ? $idFather = 'null' : $idFather = $Person->getIdFather();
            $Person->getIdMother() == 0 ? $idMother = 'null' : $idMother = $Person->getIdMother();
            $idCityAddress = $Person->getIdCityAddress();

            if ($idCityAddress === NULL)
            {
                $idCityAddress = 'NULL';
            }

            $query     = "UPDATE $tablePerson
                          SET names         = '$names', 
                              lastname1     = '$lastname1', 
                              lastname2     = '$lastname2', 
                              gender        = '$gender', 
                              address       = '$address', 
                              phoneNumber   = '$phoneNumber', 
                              idFather      = $idFather, 
                              idMother      = $idMother, 
                              idCityAddress = $idCityAddress
                          WHERE $tablePerson.id = $id";

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Search one Person by one similar names
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string        $value    String with the similar names
         * @return Array[Person] $persons  Person objects with the similar names
         */
        static function searchPerson($value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tablePerson  = DatabaseManager::getNameTable('TABLE_PERSON');

            $query     = "SELECT $tablePerson.*
                          FROM $tablePerson
                          WHERE $tablePerson.names     LIKE '%$value%' OR
                                $tablePerson.lastname2 LIKE '%$value%' OR
                                $tablePerson.lastname1 LIKE '%$value%'";

            $arrayPersons = DatabaseManager::multiFetchAssoc($query);
            $persons      = array();

            if ($arrayPersons === null)
            {
                return null;
            }

            foreach ($arrayPersons as $Person) 
            {
                $persons[] = self::ArrayToPerson($Person);
            }

            return $persons;
        }

        /**
         * Search one Person by one similar names
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string        $names       Name of the person to search
         * @param  string        $lastname1   First lastname of the person to search
         * @param  string        $lastname2   Second lastname of the person to search
         * @param  boolean       $exact       If wants a exact search or if wants a similar
         * @param  string        $operator    Select one operator fot the search like "AND" or "OR"
         * @return Array[Person] $persons     Person objects with the similar names
         */
        static function searchPersonsByNames($names = '', $lastname1 = '', 
                                             $lastname2 = '', $exact = true, $operator = 'AND')
        {
            if ($value === '')
            {
                return null;
            }

            $tablePerson = DatabaseManager::getNameTable('TABLE_PERSON');
            $query       = '';

            if ($exact)
            {
                $query = "SELECT $tablePerson.*
                          FROM $tablePerson 
                          WHERE $tablePerson.names     = '$names'     $operator
                                $tablePerson.lastname1 = '$lastname1' $operator
                                $tablePerson.lastname2 = '$lastname2'";
            }
            else
            {
                $query  = "SELECT $tablePerson.*
                           FROM $tablePerson 
                           WHERE $tablePerson.names     LIKE '$names%'     $operator
                                 $tablePerson.lastname1 LIKE '$lastname1%' $operator
                                 $tablePerson.lastname2 LIKE '$lastname2%'";
            }

            $arrayPersons = DatabaseManager::multiFetchAssoc($query);
            $persons      = array();

            if ($arrayPersons === null)
            {
                return null;
            }

            foreach ($arrayPersons as $Person) 
            {
                $persons[] = self::ArrayToPerson($Person);
            }

            return $persons;
        }
    }

 ?>
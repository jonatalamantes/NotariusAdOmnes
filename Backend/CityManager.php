<?php 
    
    require_once("City.php");
    require_once("DatabaseManager.php");

    /**
    * Class for manipulate City Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CityManager
    {
        /**
         * Transform one City object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   City    $city       city object to Transform
         * @return  Array   $cityArray  array result for transformation or null
         */
        static function CityToArray($city = null)
        {
            if ($city === null)
            {
                return null;
            }
            else
            {
                $cityArray = array();

                $cityArray['id']             = $city->getId(); 
                $cityArray['name']           = $city->getName();
                $cityArray['idState']        = $city->getIdState();

                return $cityArray;
            }
        }

        /**
         * Transform one Array object into a City Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array   $array      Array object to transform
         * @return  City    $city       City result or null
         */
        static function ArrayToCity($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $city  = new City($array['id'], $array['name'], $array['idState']);

            return $city;
        }

        /**
         * Transform one State object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   State    $state      State object to transform
         * @return  Array    $array      Array result or null
         */
        static function StateToArray($state = null)
        {
            if ($state === null)
            {
                return null;
            }

            $array = array();

            $array['id']         = $state->getId();
            $array['shortName']  = $state->getShortName();
            $array['name']       = $state->getName();
            $array['country']    = $state->getCountry();

            return $array;
        }

        /**
         * Transform one Array object into a State Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array    $array      Array object to transform
         * @return  State    $state      State result or null
         */
        static function ArrayToState($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $state = new State($array['id'],$array['shortName'], $array['name'], $array['country']);
            return $state;
        }

        /**
         * Return if two city objects are equals
         * 
         * @param  City     $city1 City 1
         * @param  City     $city2 City 2
         * @return boolean         result
         */
        static function compareCity($city1 = null, $city2 = null)
        {
            if ($city1 === null || $city2 === null)
            {
                return false;
            }
            else
            {
                if ($city1->getName() === $city2->getName())
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
         * Return if two state objects are equals
         * 
         * @param  State     $state1   State 1
         * @param  State     $state2   State 2
         * @return boolean             result
         */
        static function compareState($state1 = null, $state2 = null)
        {
            if ($state1 === null || $state2 === null)
            {
                return false;
            }
            else
            {
                if (($state1->getName()      == $state2->getName())      &&
                    ($state1->getShortName() == $state2->getShortName()) &&
                    ($state1->getCountry()   == $state2->getCountry()))
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
         * Recover from database one State object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       Key to search
         * @param  string  $value     Value of the key
         * @return State   $myState   state result or null
         */
        static function getSingleState($key = 'id', $value = 0)
        {
            if ($value === '')
            {
                return null;
            }

            $tableState = DatabaseManager::getNameTable('TABLE_STATE');

            $query      = "SELECT $tableState.*
                           FROM $tableState 
                           WHERE $tableState.$key = '$value'";

            $myState    = DatabaseManager::singleFetchAssoc($query);
            $myState    = self::ArrayToState($myState);

            return $myState;
        }

        /**
         * Recover from database one City object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string  $key       key to search
         * @param  string  $value     value of the key
         * @return City    $city      City result or null
         */
        static function getSingleCity($key = 'id', $value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableCity  = DatabaseManager::getNameTable('TABLE_CITY');

            $query     = "SELECT $tableCity.*
                          FROM $tableCity 
                          WHERE $tableCity.$key = '$value'";

            $city      = DatabaseManager::singleFetchAssoc($query);
            $city      = self::ArrayToCity($city);

            return $city;
        }

        /**
         * Recover all City from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[City]   $cities     Array of City Object
         */
        static function getAllCities()
        {
            $tableCity  = DatabaseManager::getNameTable('TABLE_CITY');

            $query     = "SELECT $tableCity.*
                          FROM $tableCity
                          ORDER BY $tableCity.name";

            $arrayCities = DatabaseManager::multiFetchAssoc($query);
            $cities      = array();

            foreach ($arrayCities as $city) 
            {
                $cities[] = self::ArrayToCity($city);
            }

            return $cities;
        }

        /**
         * Recover all States from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return Array[State]   $states     Array of states
         */
        static function getAllStates()
        {
            $tableState  = DatabaseManager::getNameTable('TABLE_STATE');

            $query     = "SELECT $tableState.*
                          FROM $tableState
                          ORDER BY $tableState.name";

            $arrayStates = DatabaseManager::multiFetchAssoc($query);
            $states      = array();

            foreach ($arrayStates as $state) 
            {
                $states[] = self::ArrayToState($state);
            }

            return $states;
        }

        /**
         * insert one city in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  City $city  The city to insert
         * @return boolean     If was possible to insert
         */
        static function addCity($city = null)
        {
            if ($city === null)
            {
                return false;
            }

            $name       = $city->getName();
            $singleCity = self::getSingleCity('name', $name);

            if (self::compareCity($singleCity, $city) === false)
            {
                $tableCity  = DatabaseManager::getNameTable('TABLE_CITY');
                $idState   = $city->getIdState();

                $query     = "INSERT INTO $tableCity
                              (name, idState)
                              VALUES 
                              ('$name', $idState)";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //City Exist
            {
                return false;
            }
        }

        /**
         * insert one state in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  State $state  The state to insert
         * @return boolean       If was possible to insert
         */
        static function addState($state = null)
        {
            if ($state === null)
            {
                return false;
            }

            $shortName  = $state->getShortName();
            $singleState = self::getSingleState('shortName', $shortName);

            if (self::compareState($singleState, $state) === false)
            {
                $tableState = DatabaseManager::getNameTable('TABLE_STATE');
                $name       = $state->getName();
                $country    = $state->getCountry();

                $query     = "INSERT INTO $tableState
                              (shortName, name, country)
                              VALUES 
                              ('$shortName', '$name', '$country')";

                return DatabaseManager::singleAffectedRow($query);
            }
            else //State exist
            {
                return false;
            }
        }

        /**
         * delete one city from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  City $city  The city to delete
         * @return boolean     if was possible to delete
         */
        static function removeCity($city = null)
        {
            if ($city === null)
            {
                return false;
            }
            else
            {
                $tableCity  = DatabaseManager::getNameTable('TABLE_CITY');
                $name       = $city->getName();
                $id         = $city->getId();

                $query     = "DELETE FROM $tableCity
                              WHERE $tableCity.id = $id";

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * update one city in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  City $city  The city to update
         * @return boolean     if was possible to update
         */
        static function updateCity($city = null)
        {
            if ($city === null)
            {
                return false;
            }

            $tableCity = DatabaseManager::getNameTable('TABLE_CITY');
            $id         = $city->getId();
            $idState   = $city->getIdState();
            $name      = $city->getName();

            $query     = "UPDATE $tableCity
                          SET name = '$name', idState = $idState
                          WHERE $tableCity.id = $id";

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * search one city by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string      $value   string with the similar name
         * @return Array[City] $cities  City objects with the similar name
         */
        static function searchCity($value = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableCity  = DatabaseManager::getNameTable('TABLE_CITY');
            $tableState = DatabaseManager::getNameTable('TABLE_STATE');

            $query     = "SELECT $tableCity.*
                          FROM $tableCity
                          WHERE $tableCity.name LIKE '%$value%'";

            $arrayCities = DatabaseManager::multiFetchAssoc($query);
            $cities      = array();

            foreach ($arrayCities as $city) 
            {
                $cities[] = self::ArrayToCity($city);
            }

            return $cities;
        }
    }

 ?>
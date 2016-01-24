<?php 
    
    session_start();

    require_once("User.php");
    require_once("PaperConfig.php");
    require_once("Church.php");
    require_once("Message.php");
    require_once("DatabaseManager.php");
    require_once("LanguageSupport.php");

    /**
    * Class for manipulate User Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class SessionManager
    {
        /**
         * Transform one User object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   User   $User       User object to Transform
         * @return  Array  $UserArray  Array result for transformation or null
         */
        static function UserToArray($User = null)
        {
            if ($User === null)
            {
                return null;
            }
            else
            {
                $UserArray = array();

                $UserArray['id']                = $User->getId(); 
                $UserArray['username']          = $User->getUsername();
                $UserArray['type']              = $User->getType();
                $UserArray['password']          = $User->getPassword();
                $UserArray['idChurch']          = $User->getIdChurch();
                $UserArray['offline']           = $User->getOffline();
                $UserArray['language']          = $User->getLanguage();
                $UserArray['idPaperConfig']     = $User->getIdPaperConfig();
                $UserArray['addressIP']         = $User->getAddressIP();

                return $UserArray;
            }
        }

        /**
         * Transform one Array object into a User Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array     $array      Array object to transform
         * @return  User      $User       User result or null
         */
        static function ArrayToUser($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $User  = new User($array['id'], $array['username'], $array['password'], $array['type'],
                              $array['idChurch'], $array['offline'], $array["language"], 
                              $array["lastActivityTime"], $array["idPaperConfig"], 
                              $array["addressIP"]);

            return $User;
        }

        /**
         * Transform one PaperConfig object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   PaperConfig  $PaperConfig       PaperConfig object to Transform
         * @return  Array        $PaperArray  Array result for transformation or null
         */
        static function PaperConfigToArray($PaperConfig = null)
        {
            if ($PaperConfig === null)
            {
                return null;
            }
            else
            {
                $PaperArray = array();

                $PaperArray['id']                    = $PaperConfig->getId(); 
                $PaperArray['baptismCertX']          = $PaperConfig->getBaptismCertX();
                $PaperArray['baptismCertY']          = $PaperConfig->getBaptismCertY();
                $PaperArray['copyBaptismCertX']      = $PaperConfig->getCopyBaptismCertX();
                $PaperArray['copyBaptismCertY']      = $PaperConfig->getCopyBaptismCertY();
        
                $PaperArray['communionCertX']        = $PaperConfig->getCommunionCertX();
                $PaperArray['communionCertY']        = $PaperConfig->getCommunionCertY();
                $PaperArray['copyCommunionCertX']    = $PaperConfig->getCopyCommunionCertX();
                $PaperArray['copyCommunionCertY']    = $PaperConfig->getCopyCommunionCertX();
                
                $PaperArray['confirmationCertX']     = $PaperConfig->getConfirmationCertX();
                $PaperArray['confirmationCertY']     = $PaperConfig->getConfirmationCertY();
                $PaperArray['copyConfirmationCertX'] = $PaperConfig->getCopyConfirmationCertX();
                $PaperArray['copyConfirmationCertY'] = $PaperConfig->getCopyConfirmationCertY();

                $PaperArray['marriageCertX']         = $PaperConfig->getMarriageCertX();
                $PaperArray['marriageCertY']         = $PaperConfig->getMarriageCertY();
                $PaperArray['marriageConstancyX']    = $PaperConfig->getMarriageConstancyX();
                $PaperArray['marriageConstancyY']    = $PaperConfig->getMarriageConstancyY();
                $PaperArray['marriageNoticeX']       = $PaperConfig->getMarriageNoticeX();
                $PaperArray['marriageNoticeY']       = $PaperConfig->getMarriageNoticeY();
                $PaperArray['marriageExhortX']       = $PaperConfig->getMarriageExhortX();
                $PaperArray['marriageExhortY']       = $PaperConfig->getMarriageExhortY();                
                $PaperArray['marriageTraslationX']   = $PaperConfig->getMarriageTraslationX();
                $PaperArray['marriageTraslationY']   = $PaperConfig->getMarriageTraslationY();

                return $PaperArray;
            }
        }

        /**
         * Transform one Array object into a PaperConfig Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array          $array           Array object to transform
         * @return  PaperConfig    $PaperConfig     PaperConfig result or null
         */
        static function ArrayToPaperConfig($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $PaperConfig  = new PaperConfig($array['id'], 

                                            $array['baptismCertX'], 
                                            $array['baptismCertY'], 
                                            $array['copyBaptismCertX'], 
                                            $array['copyBaptismCertY'],

                                            $array['communionCertX'], 
                                            $array['communionCertY'], 
                                            $array['copyCommunionCertX'], 
                                            $array['copyCommunionCertY'], 
                                            
                                            $array['confirmationCertX'], 
                                            $array['confirmationCertY'], 
                                            $array['copyConfirmationCertX'], 
                                            $array['copyConfirmationCertY'], 

                                            $array['marriageCertX'], 
                                            $array['marriageCertY'], 
                                            $array['marriageConstancyX'], 
                                            $array['marriageConstancyY'], 
                                            $array['marriageNoticeX'], 
                                            $array['marriageNoticeY'], 
                                            $array['marriageExhortX'], 
                                            $array['marriageExhortY'],                 
                                            $array['marriageTraslationX'], 
                                            $array['marriageTraslationY']);

            return $PaperConfig;
        }

        /**
         * Transform one Message object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Message  $Message       Message object to Transform
         * @return  Array    $MessageArray  Array result for transformation or null
         */
        static function MessageToArray($Message = null)
        {
            if ($Message === null)
            {
                return null;
            }
            else
            {
                $MessageArray = array();

                $MessageArray['id']         = $Message->getId(); 
                $MessageArray['contest']    = $Message->getContest();
                $MessageArray['idUserFrom'] = $Message->getIdUserFrom();
                $MessageArray['idUserTo']   = $Message->getIdUserTo();
                $MessageArray['seen']       = $Message->getSeen();
                $MessageArray['received']   = $Message->getReceived();
                $MessageArray['time']       = $Message->getTime();

                return $MessageArray;
            }
        }

        /**
         * Transform one Array object into a Message Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array      $array       Array object to transform
         * @return  Message    $Message     Message result or null
         */
        static function ArrayToMessage($array = array())
        {
            if ($array === null)
            {
                return null;
            }

            $Message  = new Message($array['id'], 
                                    $array['contest'], 
                                    $array['idUserFrom'], 
                                    $array['idUserTo'], 
                                    $array['seen'], 
                                    $array['received'], 
                                    $array['time']);

            return $Message;
        }

        /**
         * Return if two User objects are equals
         * 
         * @param  User     $User1 User 1
         * @param  User     $User2 User 2
         * @return boolean         Result
         */
        static function compareUser($User1 = null, $User2 = null)
        {
            if ($User1 === null || $User2 === null)
            {
                return false;
            }
            else
            {
                if ($User1->getUsername() == $User2->getUsername())
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
         * Recover from database one User object by id
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
         * @return User    $myUser      User result or null
         */
        static function getSingleUser($key = 'id', $value = 0, $key2 = '', $value2 = '', $key3 = '', 
                                      $value3 = '', $key4 = '', $value4 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tableUser = DatabaseManager::getNameTable('TABLE_USER');

            $query      = "SELECT $tableUser.*
                           FROM $tableUser 
                           WHERE $tableUser.$key = '$value'";

            if ($key2 !== '')
            {
                $query = $query . "AND $tableUser.$key2 = '$value2'";
            }

            if ($key3 !== '')
            {
                $query = $query . "AND $tableUser.$key3 = '$value3'";
            }

            if ($key4 !== '')
            {
                $query = $query . "AND $tableUser.$key4 = '$value4'";
            }

            $myUser    = DatabaseManager::singleFetchAssoc($query);
            $myUser    = self::ArrayToUser($myUser);

            return $myUser;
        }

        /**
         * Recover from database one Message object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string       $key       The key to search
         * @param  integer      $value     Value to search
         * @param  string       $key2      The key to search 2
         * @param  integer      $value2    Value to search 2
         * @return Message             The Message Object
         */
        static function getSingleMessage($key = 'id', $value = 0)
        {
            if ($value === '')
            {
                return null;
            }

            $tableMessage = DatabaseManager::getNameTable('TABLE_MESSAGE');

            $query      = "SELECT $tableMessage.*
                           FROM $tableMessage 
                           WHERE $tableMessage.$key = '$value'";

            if ($value2 !== '')
            {
                $query = $query . " AND $tableMessage.$key2 = '$value2'";
            }

            $myMessage  = DatabaseManager::singleFetchAssoc($query);
            $myMessage  = self::ArrayToMessage($myMessage);

            return $myMessage;
        }

        /**
         * Recover from database one Paper Config object by id
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string       $key       The key to search
         * @param  integer      $value     Value to search
         * @param  string       $key2      The key to search 2
         * @param  integer      $value2    Value to search 2
         * @return PaperConfig             The Paper Config Object
         */
        static function getSinglePaperConfig($key = 'id', $value = 0, $key2 = '', $value2 = '')
        {
            if ($value === '')
            {
                return null;
            }

            $tablePaperConfig = DatabaseManager::getNameTable('TABLE_PAPER_CONFIG');

            $query      = "SELECT $tablePaperConfig.*
                           FROM $tablePaperConfig 
                           WHERE $tablePaperConfig.$key = '$value'";

            if ($value2 !== '')
            {
                $query = $query . " AND $tablePaperConfig.$key2 = '$value2'";
            }

            $myPaperConfig  = DatabaseManager::singleFetchAssoc($query);
            $myPaperConfig  = self::ArrayToPaperConfig($myPaperConfig);

            return $myPaperConfig;
        }

        /**
         * Recover all User from the database begin in one part of the user table
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string            $order       The type of sort of the User
         * @param  integer           $begin       The number of page to display the registry
         * @return Array[User]    $users    Array of User Object
         */
        static function getAllUsers($order = 'id', $begin = 0)
        {
            $tableUser  = DatabaseManager::getNameTable('TABLE_USER');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');

            $query     = "SELECT $tableUser.* 
                          FROM $tableUser
                         JOIN $tableChurch 
                         ON $tableUser.idChurch = $tableChurch.id";

            if ($order == 'username')
            {
                $query = $query . " ORDER BY $tableUser.username";
            }
            else if ($order == 'nameChurch')
            {
                $query = $query . " ORDER BY $tableChurch.name";
            }
            else
            {
                $query = $query . " ORDER BY $tableUser.id DESC";
            }

            if ($begin !== -1)
            {
                $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";
            }

            $arrayUsers = DatabaseManager::multiFetchAssoc($query);
            $users      = array();

            if ($arrayUsers !== NULL)
            {
                $i = 0;
                foreach ($arrayUsers as $user) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $users[] = self::ArrayToUser($user);
                    $i++;
                }

                return $users;
            }
            else
            {
                return null;
            }
        }

        /**
         * Insert one PaperConfig in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  PaperConfig   $PaperConfig  The PaperConfig to insert
         * @return boolean                     If was possible to insert
         */
        static function addPaperConfig($PaperConfig = null)
        {
            if ($PaperConfig === null)
            {
                return false;
            }

            $tablePaperConfig   = DatabaseManager::getNameTable('TABLE_PAPER_CONFIG');

            $baptismCertX         = $PaperConfig->getBaptismCertX();
            $baptismCertY         = $PaperConfig->getBaptismCertY();
            $copyBaptismCertX     = $PaperConfig->getCopyBaptismCertX();
            $copyBaptismCertY     = $PaperConfig->getCopyBaptismCertY();
    
            $communionCertX       = $PaperConfig->getCommunionCertX();
            $communionCertY       = $PaperConfig->getCommunionCertY();
            $copyCommunionCertX   = $PaperConfig->getCopyCommunionCertX();
            $copyCommunionCertY   = $PaperConfig->getCopyCommunionCertY();
            
            $confirmationCertX    = $PaperConfig->getConfirmationCertX();
            $confirmationCertY    = $PaperConfig->getConfirmationCertY();
            $copyConfirmationCertX= $PaperConfig->getCopyConfirmationCertX();
            $copyConfirmationCertY= $PaperConfig->getCopyConfirmationCertY();

            $marriageCertX        = $PaperConfig->getMarriageCertX();
            $marriageCertY        = $PaperConfig->getMarriageCertY();
            $marriageConstancyX   = $PaperConfig->getMarriageConstancyX();
            $marriageConstancyY   = $PaperConfig->getMarriageConstancyY();
            $marriageNoticeX      = $PaperConfig->getMarriageNoticeX();
            $marriageNoticeY      = $PaperConfig->getMarriageNoticeY();
            $marriageExhortX      = $PaperConfig->getMarriageExhortX();
            $marriageExhortY      = $PaperConfig->getMarriageExhortY();                
            $marriageTraslationX  = $PaperConfig->getMarriageTraslationX();
            $marriageTraslationY  = $PaperConfig->getMarriageTraslationY();

            $query     = "INSERT INTO $tablePaperConfig
                          (baptismCertX,       baptismCertY,          copyBaptismCertX,      
                           copyBaptismCertY,   communionCertX,        communionCertY,    
                           copyCommunionCertX, copyCommunionCertY,    confirmationCertX, 
                           confirmationCertY,  copyConfirmationCertX, copyConfirmationCertY,
                           marriageCertX,      marraigeCertY,         marriageConstancyX, 
                           marriageConstancyY, marriageNoticeX,       marriageNoticeY, 
                           marriageExhortX,    marriageExhortY,       marriageTraslationX, 
                           marriageTraslationY)
                          VALUES 
                          ($baptismCertX,       $baptismCertY,          $copyBaptismCertX,      
                           $copyBaptismCertY,   $communionCertX,        $communionCertY,    
                           $copyCommunionCertX, $copyCommunionCertY,    $confirmationCertX, 
                           $confirmationCertY,  $copyConfirmationCertX, $copyConfirmationCertY,
                           $marriageCertX,      $marraigeCertY,         $marriageConstancyX, 
                           $marriageConstancyY, $marriageNoticeX,       $marriageNoticeY, 
                           $marriageExhortX,    $marriageExhortY,       $marriageTraslationX, 
                           $marriageTraslationY)";

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Insert one User in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  User     $User  The User to insert
         * @return boolean         If was possible to insert
         */
        static function addUser($User = null)
        {
            if ($User === null)
            {
                return false;
            }

            $username  = $User->getUsername();
            $singleUser = self::getSingleUser('username', $username);

            if (self::compareUser($singleUser, $User) === false)
            {
                $tableUser   = DatabaseManager::getNameTable('TABLE_USER');

                $type       = $User->getType();
                $password   = $User->getPassword();
                $User->getIdChurch() == 0 ? $idChurch = 'null' : $idChurch = $User->getIdChurch();

                //Insert one paper Config
                self::addPaperConfig(new PaperConfig());
                $idPaperConfig = self::getLastIDPaperConfig();

                $query     = "INSERT INTO $tableUser
                              (username,      type,      password, idChurch, offline, 
                               idPaperConfig, addressIP, language)
                              VALUES 
                              ('$username',     '$type',   '$password', '$idChurch', 1, 
                                $idPaperConfig, '0.0.0.0', 'es')";
                
                return DatabaseManager::singleAffectedRow($query);
            }
            else //User Exist
            {
                return false;
            }
        }

        /**
         * Insert one Message in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Message     $Message  The Message to insert
         * @return boolean         If was possible to insert
         */
        static function addMessage($Message = null)
        {
            if ($Message === null)
            {
                return false;
            }

            $tableMessage   = DatabaseManager::getNameTable('TABLE_MESSAGE');

            $contest    = $Message->getContest();
            $idUserFrom = $Message->getIdUserFrom();
            $idUserTo   = $Message->getIdUserTo();
            $time       = $Message->getTime();

            $query     = "INSERT INTO $tableMessage
                          (contest, idUserFrom, idUserTo, seen, received, time)
                          VALUES 
                          ('$contest', '$idUserFrom', '$idUserTo', 0, 1, $time)";
            
            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Recover the last ID from the database of user
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return integer         The last id on the database
         */
        static function getLastID()
        {
            $tableUser  = DatabaseManager::getNameTable('TABLE_USER');

            $query     = "SELECT MAX(id) AS Max FROM $tableUser";

            return DatabaseManager::singleFetchAssoc($query)["Max"];
        }

        /**
         * Recover the last ID from the database of paper config
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return integer         The last id on the database of paper config
         */
        static function getLastIDPaperConfig()
        {
            $tablePaperConfig  = DatabaseManager::getNameTable('TABLE_PAPER_CONFIG');

            $query     = "SELECT MAX(id) AS Max FROM $tablePaperConfig";

            return DatabaseManager::singleFetchAssoc($query)["Max"];
        }
        /**
         * Delete one PaperConfig from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  PaperConfig $PaperConfig  The PaperConfig to delete
         * @return boolean                   If was possible to delete
         */
        static function removePaperConfig($PaperConfig = null)
        {
            if ($PaperConfig === null)
            {
                return false;
            }
            else
            {
                $tablePaperConfig  = DatabaseManager::getNameTable('TABLE_PAPER_CONFIG');
                $id         = $PaperConfig->getId();

                $query      = "DELETE FROM $tablePaperConfig
                               WHERE $tablePaperConfig.id = $id";

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * Delete one User from the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  User     $User  The User to delete
         * @return boolean         If was possible to delete
         */
        static function removeUser($User = null)
        {
            if ($User === null)
            {
                return false;
            }
            else
            {
                $tableUser  = DatabaseManager::getNameTable('TABLE_USER');
                $id         = $User->getId();

                self::removePaperConfig($User->getIdPaperConfig());

                $query      = "DELETE FROM $tableUser
                               WHERE $tableUser.id = $id";

                return DatabaseManager::singleAffectedRow($query);
            }
        }

        /**
         * Update one PaperConfig in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  PaperConfig    $PaperConfig  The PaperConfig to update
         * @return boolean                      If was possible to update
         */
        static function updatePaperConfig($PaperConfig = null)
        {
            if ($PaperConfig === null)
            {
                return false;
            }

            $tablePaperConfig = DatabaseManager::getNameTable('TABLE_PAPER_CONFIG');

            $id                   = $PaperConfig->getId();

            $baptismCertX         = $PaperConfig->getBaptismCertX();
            $baptismCertY         = $PaperConfig->getBaptismCertY();
            $copyBaptismCertX     = $PaperConfig->getCopyBaptismCertX();
            $copyBaptismCertY     = $PaperConfig->getCopyBaptismCertY();
    
            $communionCertX       = $PaperConfig->getCommunionCertX();
            $communionCertY       = $PaperConfig->getCommunionCertY();
            $copyCommunionCertX   = $PaperConfig->getCopyCommunionCertX();
            $copyCommunionCertY   = $PaperConfig->getCopyCommunionCertY();
            
            $confirmationCertX    = $PaperConfig->getConfirmationCertX();
            $confirmationCertY    = $PaperConfig->getConfirmationCertY();
            $copyConfirmationCertX= $PaperConfig->getCopyConfirmationCertX();
            $copyConfirmationCertY= $PaperConfig->getCopyConfirmationCertY();

            $marriageCertX        = $PaperConfig->getMarriageCertX();
            $marriageCertY        = $PaperConfig->getMarriageCertY();
            $marriageConstancyX   = $PaperConfig->getMarriageConstancyX();
            $marriageConstancyY   = $PaperConfig->getMarriageConstancyY();
            $marriageNoticeX      = $PaperConfig->getMarriageNoticeX();
            $marriageNoticeY      = $PaperConfig->getMarriageNoticeY();
            $marriageExhortX      = $PaperConfig->getMarriageExhortX();
            $marriageExhortY      = $PaperConfig->getMarriageExhortY();                
            $marriageTraslationX  = $PaperConfig->getMarriageTraslationX();
            $marriageTraslationY  = $PaperConfig->getMarriageTraslationY();

            $query     = "UPDATE $tablePaperConfig
                          SET    baptismCertX          = $baptismCertX,      
                                 baptismCertY          = $baptismCertY, 
                                 copyBaptismCertX      = $copyBaptismCertX, 
                                 copyBaptismCertY      = $copyBaptismCertY,
                                 communionCertX        = $communionCertX,
                                 communionCertY        = $communionCertY,
                                 copyCommunionCertX    = $copyCommunionCertX,
                                 copyCommunionCertY    = $copyCommunionCertY,
                                 confirmationCertX     = $confirmationCertX,
                                 confirmationCertY     = $confirmationCertY,
                                 copyConfirmationCertX = $copyConfirmationCertX,
                                 copyConfirmationCertY = $copyConfirmationCertY,
                                 marriageCertX         = $marriageCertX,
                                 marriageCertY         = $marriageCertY,
                                 marriageConstancyX    = $marriageConstancyX,
                                 marriageConstancyY    = $marriageConstancyY,
                                 marriageNoticeX       = $marriageNoticeX,
                                 marriageNoticeY       = $marriageNoticeY,
                                 marriageExhortX       = $marriageExhortX,
                                 marriageExhortY       = $marriageExhortY,
                                 marriageTraslationX   = $marriageTraslationX,
                                 marriageTraslationY   = $marriageTraslationY
                          WHERE $tablePaperConfig.id = $id";

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Update one Message in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  Message     $Message  The Message to update
         * @return boolean         If was possible to update
         */
        static function updateMessage($Message = null)
        {
            if ($Message === null)
            {
                return false;
            }

            $tableMessage = DatabaseManager::getNameTable('TABLE_MESSAGE');

            $id        = $Message->getId();
            $seen      = $Message->getSeen();

            $query     = "UPDATE $tableMessage
                          SET seen = $seen
                          WHERE $tableMessage.id = $id";

            return DatabaseManager::singleAffectedRow($query);
        }

        /**
         * Update one User in the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  User     $User  The User to update
         * @return boolean         If was possible to update
         */
        static function updateUser($User = null)
        {
            if ($User === null)
            {
                return false;
            }

            $tableUser = DatabaseManager::getNameTable('TABLE_USER');

            $id        = $User->getId();
            $username  = $User->getUsername();
            $type      = $User->getType();
            $password  = $User->getPassword();
            $User->getIdChurch() == 0 ? $idChurch = 'null' : $idChurch = $User->getIdChurch();
            $offline   = $User->getOffline();
            $lastAct   = $User->getLastActivityTime();
            $language  = $User->getLanguage();
            $idPaperConfig = $User->getIdPaperConfig();
            $ip        = $User->getAddressIP();

            $query     = "UPDATE $tableUser
                          SET username = '$username', type = '$type', password = '$password', 
                              idChurch = $idChurch, offline = $offline, language = '$language',
                              lastActivityTime = '$lastAct', idPaperConfig = $idPaperConfig, 
                              addressIP = '$ip'
                          WHERE $tableUser.id = $id";

            return DatabaseManager::singleAffectedRow($query);
        }
        
        /**
         * Search one user by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string         $string       Necesary string to search
         * @param  string         $order        The type of sort of the User
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[User] $users     User objects with the similar name or null
         */
        static function simpleSearchUser($string = '', $order = "id", $begin = 0)
        {
            $tableUser  = DatabaseManager::getNameTable('TABLE_USER');
            $tableChurch   = DatabaseManager::getNameTable('TABLE_CHURCH');

            $query     = "SELECT $tableUser.* 
                          FROM $tableUser 
                          JOIN $tableChurch 
                          ON $tableUser.idChurch = $tableChurch.id
                          WHERE $tableUser.username  LIKE '%$string%' OR
                                $tableUser.type      LIKE '%$string%' OR
                                $tableChurch.name    LIKE '%$string%' OR
                                $tableUser.id        LIKE '%$string%'";

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
                $query = $query . " ORDER BY $tableUser.id";
            }

            $query = $query. " LIMIT " . strval($begin * 10) . ", 11 ";

            $arrayUsers = DatabaseManager::multiFetchAssoc($query);
            $users      = array();

            if ($arrayUsers === NULL)
            {
                return null;
            }
            else
            {
                $i = 0;
                foreach ($arrayUsers as $user) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $users[] = self::ArrayToUser($user);
                    $i++;
                }

                return $users;
            }
        }

        /**
         * Search one user by one similar name
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  User           $user         Pseudo-user with the data to search
         * @param  string         $operator     To search with 'or' or 'and'
         * @param  string         $order        The type of sort of the User
         * @param  integer        $begin        The number of page to display the registry
         * @return Array[User] $users     User objects with the similar name or null
         */
        static function advancedSearchUser($user = null, $operator = 'AND', $order = 'id', $begin = 0)
        {
            if ($user === null)
            {
                return null;
            }

            $tableUser = DatabaseManager::getNameTable('TABLE_USER');
            $tableChurch  = DatabaseManager::getNameTable('TABLE_CHURCH');

            $username = $user->getUsername();
            $type     = $user->getType();
            $online  = $user->getOffline();
            $user->getId() == 0 ? $id = '' : $id = $user->getId();

            if ($online == 'true')
            {
                $online = "0";
            }
            else
            {
                $online = "";
            }

            if ($type == '0')
            {
                $type = "";
            }
            else if ($type == '1')
            {
                $type = "A";
            }
            else if ($type == '2')
            {
                $type = "G";
            }

            $queryChurch     = "(";
            $posibleChurch   = $user->getIdChurch();

            if ($posibleChurch !== NULL) //If exist church
            {
                for ($i = 0; $i < sizeof($posibleChurch) - 1; $i++)
                {
                    $queryChurch = $queryChurch . $posibleChurch[$i]->getId() . ",";
                }

                $queryChurch  = $queryChurch.$posibleChurch[sizeof($posibleChurch)-1]->getId(). ")";
                $queryChurch  = "(c.id IN " . $queryChurch . ")";
            }

            $query =   "SELECT b.* FROM $tableUser AS b
                        JOIN $tableChurch AS c  ON b.idChurch = c.id
                        WHERE b.id               LIKE '%$id%'        $operator
                              b.type             LIKE '%$type%'      $operator
                              b.username         LIKE '%$username%'  $operator ";

            if ($online !== '')
            {
                $query = $query . "b.offline = $online $operator ";
            }

            if ($queryChurch != '(')
            {
                $query = $query . $queryChurch . " ";
            }
            else
            {
                $query = $query . "(c.id IN ())" . " ";
            }
            if ($order == 'username')
            {
                $query = $query . " ORDER BY b.username";
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

            $arrayUsers = DatabaseManager::multiFetchAssoc($query);
            $users      = array();

            if ($arrayUsers !== NULL)
            {
                $i = 0;
                foreach ($arrayUsers as $user) 
                {
                    if ($i == 10)
                    {
                        continue;
                    }

                    $users[] = self::ArrayToUser($user);
                    $i++;
                }

                return $users;
            }
            else
            {
                return null;
            }
        }

        /**
         * Search one Message by one similar messagename
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string           $value    String with the similar messagename
         * @return Array[Message]   $messages    Message objects with the similar messagename
         */
        static function getContacts($user = null)
        {
            if ($user === null)
            {
                return null;
            }

            $tableMessage  = DatabaseManager::getNameTable('TABLE_MESSAGE');
            $tableUser     = DatabaseManager::getNameTable('TABLE_USER');
            $idUser        = $user->getId();
  
            $query     = "SELECT DISTINCT u.* 
                         FROM (SELECT * FROM $tableMessage ORDER BY time DESC) AS m 
                         JOIN $tableUser as u 
                         ON u.id = m.idUserTo OR m.idUserFrom = u.id
                         WHERE m.idUserTo = $idUser OR m.idUserFrom = $idUser";

            $arrayMessages = DatabaseManager::multiFetchAssoc($query);
            $messages      = array();

            if ($arrayMessages === null)
            {
                return null;
            }

            foreach ($arrayMessages as $Message) 
            {
                $messages[] = self::ArrayToUser($Message);
            }

            return $messages;
        }

        /**
         * Search one Message by one similar messagename
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string           $value    String with the similar messagename
         * @return Array[Message]   $messages    Message objects with the similar messagename
         */
        static function filterMessage($operator = 'OR', $key1 = '', $value1 = '', $key2 = '', 
                                      $value2 = '', $key3 = '', $value3 = '')
        {
            if ($valu1 === '')
            {
                return null;
            }

            $tableMessage  = DatabaseManager::getNameTable('TABLE_MESSAGE');

            $query     = "SELECT $tableMessage.*
                          FROM $tableMessage
                          WHERE $tableMessage.$key1   = $value1";

            if ($value2 !== '')
            {
                $query = $query . " $operator $tableMessage.$key2 = $value2";
            }

            if ($value3 !== '')
            {
                $query = $query . " $operator $tableMessage.$key3 = $value3";
            }

            $arrayMessages = DatabaseManager::multiFetchAssoc($query);
            $messages      = array();

            if ($arrayMessages === null)
            {
                return null;
            }

            foreach ($arrayMessages as $Message) 
            {
                $messages[] = self::ArrayToMessage($Message);
            }

            return $messages;
        }

        /**
         * Search one Message by one similar messagename
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string           $value    String with the similar messagename
         * @return Array[Message]   $messages    Message objects with the similar messagename
         */
        static function getConversation($idUser1 = null, $idUser2 = null, $limit = '10')
        {
            if ($idUser1 == null || $idUser2 == null)
            {
                return null;
            }

            $tableMessage  = DatabaseManager::getNameTable('TABLE_MESSAGE');

            $query     = "SELECT $tableMessage.*
                          FROM $tableMessage
                          WHERE ($tableMessage.idUserFrom = $idUser1 AND
                                 $tableMessage.idUserTo   = $idUser2) OR
                                ($tableMessage.idUserTo   = $idUser1 AND
                                 $tableMessage.idUserFrom = $idUser2)
                               ORDER BY id DESC LIMIT $limit";

            $arrayMessages = DatabaseManager::multiFetchAssoc($query);
            $messages      = array();

            if ($arrayMessages === null)
            {
                return null;
            }

            foreach ($arrayMessages as $Message) 
            {
                $messages[] = self::ArrayToMessage($Message);
            }

            return $messages;
        }

        /**
         * Recover the user data if is a valid user
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string $username  The username to validate
         * @param  string $password  The password of the username (previos encrypt with SHA1)
         * @return User              The user data from the database
         */
        static function validateUser($username = '', $password = '')
        {
            if ($username == '')
            {
                return null;
            }
            else
            {
                $status = self::userLogin($username, $password);

                if ($status === false)
                {
                    return null;
                }
                else
                {
                    $users = self::getSingleUser('username', $username, 'password', $password);

                    return $users;
                }
            }
        }

        /**
         * Change the status of one user on the database for online
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string $username  The username
         * @param  string $password  The password
         * @return boolean           If was posible to change the status
         */
        static function userLogin($username = "", $password = "")
        {
            $user = self::getSingleUser('username', $username, 'password', $password);

            if ($user !== NULL && $user->getOffline() == 1) //is offline
            {
                $user->setOffline("0");
                $user->setAddressIP($_SERVER['REMOTE_ADDR']);

                self::updateUser($user);

                $_SESSION["user_id"]   = $user->getId();
                $_SESSION["user_name"] = $user->getUsername();
                $_SESSION["user_type"] = $user->getType();
                $_SESSION["user_church"] = $user->getIdChurch();
                $_SESSION["last_page"] = "";
                $_SESSION["curr_page"] = "";

                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * Change the status of one user on the database for offline
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return boolean             If was posible to change the status
         */
        static function userLogout()
        {
            $user = self::getCurrentUser();

            if ($user->getOffline == 0) //is Online
            {
                $user->setOffline(1);
                self::updateUser($user);

                $_SESSION["user_name"] = NULL;
                $_SESSION["user_type"] = NULL;
                $_SESSION["user_id"]   = NULL;
                $_SESSION["last_page"] = NULL;
                $_SESSION["curr_page"] = NULL;

                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * Mark the actual user like Discconected
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         */
        static function momentDisconect()
        {
            $user = self::getCurrentUser();

            if ($user !== NULL)
            {
                $user->setOffline(1);
                self::updateUser($user);
            }
        }

        /**
         * Mark the actual user like Connect
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         */
        static function momentConnect()
        {
            $user = self::getCurrentUser();

            if ($user !== NULL)
            {
                $user->setOffline(0);
                self::updateUser($user);
            }
        }

        /**
         * Disconect one user after 600 seconds of inactivity
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         */
        function timeOut()
        {
            //Get Offline to user that are 600 second out
            $users = self::getAllUsers('id', -1);

            foreach ($users as $singleUser)
            {
                if (time() - intval($singleUser->getLastActivityTime()) > 600)
                {
                    $singleUser->setOffline(1);
                    self::updateUser($singleUser);
                }
            }
            
            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== NULL)
            {
                //Put the new time activity
                $userOnline = self::getCurrentUser();
                $userOnline->setLastActivityTime(time());
                self::updateUser($userOnline);
                LanguageSupport::changeLanguage($userOnline->getLanguage());
            }
        }

        /**
         * Get the last page $_SESSION
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   The past page
         */
        static function getLastPage()
        {
            return $_SESSION["last_page"];
        }

        /**
         * Get the current page $_SESSION
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   The current page
         */
        static function getCurrentPage()
        {
            return $_SESSION["curr_page"];
        }

        /**
         * Get the last query $_SESSION
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   The last query
         */
        static function getLastQuery()
        {
          return $_SESSION["last_query"];
        }

        /**
         * Change the last query on the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   $newQuery   The new query
         */
        static function setLastQuery($newQuery = "")
        {
          $_SESSION["last_query"] = $newQuery;
        }

        /**
         * Validate the user in the actual page, if not user, move to index page
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string    $page   The actual page
         */
        static function validateUserInPage($page = "", $idChurch = 0, $idChurch2 = -1)
        {
            self::timeOut();

            if ($page !== $_SESSION["curr_page"])
            {
                if ($page !== 'stateInsertion.php')
                {
                    $_SESSION["last_page"] = $_SESSION["curr_page"];
                    $_SESSION["curr_page"] = $page;
                }
            }

            if ($page == 'index.php' || $page == '')
            {
                if (isset($_SESSION["user_name"]) && $_SESSION["user_name"] !== NULL)
                {
                    echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
                }
            }
            else
            {
                if (!isset($_SESSION["user_name"]) || $_SESSION["user_name"] === NULL)
                {
                    echo "<script src='../JS/functions.js'></script><script>href('index.php')</script>";
                }
            }

            if ($_SESSION["user_type"] == 'G')
            {
                if ($page == 'addRelationChurchRector.php' || $page == 'userInsertion.php' ||
                    $page == 'rectorChange.php'            || $page == 'rectorInsertion.php' ||
                    $page == 'churchInsertion.php'         || $page == 'churchChange.php'    ||
                    $page == 'cityInsertion.php'           || $page == 'deanInsertion.php'   ||
                    $page == 'vicarInsertion.php'          || $page == 'stateInsertion.php')
                {
                    echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
                }
                else if ($page == 'baptismChange.php'      || $page == 'communionChange.php' ||
                         $page == 'confirmationChange.php' || $page == 'marriageChange.php'  ||
                         $page == 'defuntionChange.php'    || $page == 'proofChange.php'     ||
                         $page == '' || $page == '' ||
                         $page == '' || $page == '' ||
                         $page == '' || $page == '' ||
                         $page == '' || $page == '')
                {
                    if (!($idChurch == $_SESSION["user_church"] || $idChurch2 == $_SESSION["user_church"]))
                    {
                        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
                    }
                }
            }
        }

        /**
         * Get the current user using the aplication in this system
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return User   The actual user using the system
         */
        static function getCurrentUser()
        {
            return self::getSingleUser('id', $_SESSION["user_id"]);
        }

        static function permisionTag($stringToTransform = "", $token = '~')
        {
            $stringResult = "";
            $bandDelete = false;
            $actual     = "";

            for ($i = 0; $i < strlen($stringToTransform); $i++)
            {
                $actual = substr($stringToTransform, $i, 1);

                if ($actual == $token)
                {
                    $stringResult = $stringResult . " ";

                    if ($_SESSION["user_type"] != 'A') //is G
                    {
                        if ($bandDelete)
                        {
                            $bandDelete = false;
                        }
                        else
                        {
                            $bandDelete = true;
                        }
                    }
                }
                else
                {
                    if ($bandDelete == false)
                    {
                        $stringResult = $stringResult . $actual;
                    }
                }
            }

            return $stringResult;
        }

        /**
         * Get the navbar using in the pages in relation with the type of user
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string    The HTML navbar to use
         */
        static function getNavBar()
        {
            //Get the Message Amount
            $user = self::getCurrentUser();
            
            if ($user !== NULL)
            {
                $messages = self::filterMessage('AND', 'idUserTo', $user->getId(), 'seen', 0);    
            }
            else
            {
                $messages = NULL;
            }
            
            $amount = 0;
            $nav = "";

            if ($messages !== NULL)
            {
                $amount = sizeof($messages);
            }

            if ($_SESSION["user_type"] == 'A')
            {
                $nav = '<nav class="navbar navbar-inverse navbar-fixed-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="main.php" id="headerLanguage">^Welcome To^ N.A.O</a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="main.php">^Home^</a></li>
                                <li><a href="userContact.php">^Messages (' . strval($amount) . ') ^</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">^Go To Menu^<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="baptismMenu.php">^Baptism^</a></li>
                                        <li><a href="communionMenu.php">^Communion^</a></li>
                                        <li><a href="confirmationMenu.php">^Confirmation^</a></li>
                                        <li><a href="marriageMenu.php">^Marriage^</a></li>
                                        <li class="divider"></li>
                                        <li><a href="defuntionMenu.php">^Defuntion^</a></li>
                                        <li><a href="proofMenu.php">^Proof^</a></li>
                                        <li class="divider"></li>
                                        <li><a href="churchMenu.php">^Church^</a></li>
                                        <li><a href="rectorMenu.php">^Rector^</a></li>
                                        <li><a href="userMenu.php">^User^</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">^Insert New Registry^<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="baptismInsertion.php">^Baptism^</a></li>
                                        <li><a href="communionInsertion.php">^Communion^</a></li>
                                        <li><a href="confirmationInsertion.php">^Confirmation^</a></li>
                                        <li><a href="marriageInsertion.php">^Marriage^</a></li>
                                        <li class="divider"></li>
                                        <li><a href="defuntionInsertion.php">^Defuntion^</a></li>
                                        <li><a href="proofInsertion.php">^Proof^</a></li>
                                        <li class="divider"></li>
                                        <li><a href="churchInsertion.php">^Church^</a></li>
                                        <li><a href="rectorInsertion.php">^Rector^</a></li>
                                        <li><a href="userInsertion.php">^User^</a></li>
                                    </ul>
                                </li>
                                <li><a href="config.php">^Config^</a></li>
                                <li><a href="#" onclick="logout();">^Logout^</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>';
            }
            else //is G
            {
                $nav = '<nav class="navbar navbar-inverse navbar-fixed-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="main.php" id="headerLanguage">^Welcome To^ N.A.O</a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="main.php">^Home^</a></li>
                                <li><a href="userContact.php">^Messages (' . strval($amount) . ') ^</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">^Go To Menu^<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="baptismMenu.php">^Baptism^</a></li>
                                        <li><a href="communionMenu.php">^Communion^</a></li>
                                        <li><a href="confirmationMenu.php">^Confirmation^</a></li>
                                        <li><a href="marriageMenu.php">^Marriage^</a></li>
                                        <li class="divider"></li>
                                        <li><a href="defuntionMenu.php">^Defuntion^</a></li>
                                        <li><a href="proofMenu.php">^Proof^</a></li>
                                        <li class="divider"></li>
                                        <li><a href="churchMenu.php">^Church^</a></li>
                                        <li><a href="rectorMenu.php">^Rector^</a></li>
                                        <li><a href="userMenu.php">^User^</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">^Insert New Registry^<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="baptismInsertion.php">^Baptism^</a></li>
                                        <li><a href="communionInsertion.php">^Communion^</a></li>
                                        <li><a href="confirmationInsertion.php">^Confirmation^</a></li>
                                        <li><a href="marriageInsertion.php">^Marriage^</a></li>
                                        <li class="divider"></li>
                                        <li><a href="defuntionInsertion.php">^Defuntion^</a></li>
                                        <li><a href="proofInsertion.php">^Proof^</a></li>
                                    </ul>
                                </li>
                                <li><a href="config.php">^Config^</a></li>
                                <li><a href="#" onclick="logout();">^Logout^</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>';
            }

            return $nav;
        }
    }

 ?>
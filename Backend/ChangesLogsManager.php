<?php 

    require_once("ChangesLogs.php");
    require_once("SessionManager.php");

    /**
    * Class to register the activity of the ChangeLogs Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ChangesLogsManager
    {
        /**
         * Transform one ChangesLogs object into a Array
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   ChangesLogs $changesLogs    changesLogs object to Transform
         * @return  Array     $changesLogs    array result for transformation or null
         */
        static function ChangesLogsToArray($changesLogs = null)
        {
            if ($changesLogs === null)
            {
                return null;
            }
            else
            {
                $changesLogsArray = array();

                $changesLogsArray['id']          = $changesLogs->getId();
                $changesLogsArray['date']        = $changesLogs->getDate();
                $changesLogsArray['type']        = $changesLogs->getType();
                $changesLogsArray['description'] = $changesLogs->getDescription();
                $changesLogsArray['idUser']      = $changesLogs->getIdUser();

                return $changesLogsArray;
            }
        }

        /**
         * Transform one Array object into a ChangesLogs Object
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   Array      $changesLogs   Array object to transform
         * @return  ChangesLogs  $changesLogs   ChangesLogs result or null
         */
        static function ArrayToChangesLogs($changesLogsArray = array())
        {
            if ($changesLogsArray === null)
            {
                return null;
            }

            $changesLogs = new ChangesLogs($changesLogsArray['id'],      
                                           $changesLogsArray['date'], 
                                           $changesLogsArray['type'], 
                                           $changesLogsArray['description'], 
                                           $changesLogsArray['idUser']);

            return $changesLogs;
        }

        /**
         * Insert one changes logs to the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param   String       $typéChange    The type of the change to efect (insert, update, delete)
         * @param   String       $descriptionC  The description of the change
         * @return  boolean      If was posible to insert the data
         */
        static function addChangesLogs($typeChange = "", $descriptionC = "")
        {        
            if ($typeChange == "")
            {
                return false;
            }
                        
            $date = time();
            $user = SessionManager::getCurrentUser();
            
            if ($user === NULL)
            {
                return false;
            }
            
            $idUser = $user->getId();
            $tableChangesLogs = DatabaseManager::getNameTable('TABLE_CHANGES_LOGS');
            
            $query     = "INSERT INTO $tableChangesLogs
                          (date, idUser, type, description) 
                          VALUES 
                          ($date, $idUser, '$typeChange', '$descriptionC')";
                        
            return DatabaseManager::singleAffectedRow($query);
        }
    }

 ?>
<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/CommunionManager.php");

    if (!isset($_GET) || $_GET["idCommunion"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $communion = CommunionManager::getSingleCommunion("id", $_GET["idCommunion"]);
            
        if ($communion === NULL)
        {
            echo "KO";
        }
        else
        {
            if (!isset($_SESSION) || $_SESSION["user_church"] === NULL)
            {
                echo "KO";
            }
            else
            {
                //Check for permision
                if ($_SESSION["user_type"] == 'A' || 
                    $_SESSION["user_church"] == $communion->getIdChurch())
                {
                    if (CommunionManager::removeCommunion($communion))
                    {
                        echo "OK";
                    }
                    else
                    {
                        echo "KO";
                    }
                }
            }
        }
    }

 ?>
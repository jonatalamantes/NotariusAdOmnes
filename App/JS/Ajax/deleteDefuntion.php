<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/DefuntionManager.php");

    if (!isset($_GET) || $_GET["idDefuntion"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $defuntion = DefuntionManager::getSingleDefuntion("id", $_GET["idDefuntion"]);
            
        if ($defuntion === NULL)
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
                    $_SESSION["user_church"] == $defuntion->getIdChurch())
                {
                    if (DefuntionManager::removeDefuntion($defuntion))
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
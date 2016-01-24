<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/MarriageManager.php");

    if (!isset($_GET) || $_GET["idMarriage"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $marriage = MarriageManager::getSingleMarriage("id", $_GET["idMarriage"]);
            
        if ($marriage === NULL)
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
                    $_SESSION["user_church"] == $marriage->getIdChurchMarriage() ||
                    $_SESSION["user_church"] == $marriage->getIdChurchProcess() )
                {
                    if (MarriageManager::removeMarriage($marriage))
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
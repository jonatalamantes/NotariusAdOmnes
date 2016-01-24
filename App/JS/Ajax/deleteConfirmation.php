<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/ConfirmationManager.php");

    if (!isset($_GET) || $_GET["idConfirmation"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $confirmation = ConfirmationManager::getSingleConfirmation("id", $_GET["idConfirmation"]);
            
        if ($confirmation === NULL)
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
                    $_SESSION["user_church"] == $confirmation->getIdChurch())
                {
                    if (ConfirmationManager::removeConfirmation($confirmation))
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
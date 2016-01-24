<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_GET) || $_GET["idChurch"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $church = ChurchManager::getSingleChurch("id", $_GET["idChurch"]);
            
        if ($church === NULL)
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
                if ($_SESSION["user_type"] == 'A')
                {
                    if (ChurchManager::removeChurch($church))
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
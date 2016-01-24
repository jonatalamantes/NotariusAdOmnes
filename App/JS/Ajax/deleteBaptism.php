<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/BaptismManager.php");

    if (!isset($_GET) || $_GET["idBaptism"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $baptism = BaptismManager::getSingleBaptism("id", $_GET["idBaptism"]);
            
        if ($baptism === NULL)
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
                    $_SESSION["user_church"] == $baptism->getIdChurch())
                {
                    if (BaptismManager::removeBaptism($baptism))
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
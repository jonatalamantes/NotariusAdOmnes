<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_GET) || $_GET["idRector"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $rector = RectorManager::getSingleRector("id", $_GET["idRector"]);
            
        if ($rector === NULL)
        {
            echo "KO";
        }
        else
        {
            if (!isset($_SESSION) || $_SESSION["user_type"] === NULL)
            {
                echo "KO";
            }
            else
            {
                //Check for permision
                if ($_SESSION["user_type"] == 'A')
                {
                    if (RectorManager::removeRector($rector))
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
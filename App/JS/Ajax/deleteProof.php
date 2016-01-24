<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/ProofManager.php");

    if (!isset($_GET) || $_GET["idProof"] === NULL)
    {
        echo "KO";
    }
    else
    {
        $proof = ProofManager::getSingleProofTalks("id", $_GET["idProof"]);
            
        if ($proof === NULL)
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
                    $_SESSION["user_church"] == $proof->getIdChurch())
                {
                    if (ProofManager::removeProofTalks($proof))
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
<?php 

    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_POST) || $_POST["churchName"] === NULL)
    {
        echo "KO";
        die;
    }

    $church = ChurchManager::getSingleChurch('name', $_POST["churchName"]);

    if ($church->getIdNiche() !== NULL)
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_POST) || $_POST["username"] === NULL)
    {
        echo "KO";
        die;
    }

    $user = new User();
    $church  = ChurchManager::getSingleChurch('name', $_POST["church"]);

    $user->setPassword(sha1($_POST["password"]));
    $user->setUsername($_POST["username"]);

    if ($_POST["type"] == '0')
    {
        $user->setType('A');
    }
    else
    {
        $user->setType('G');
    }

    $user->setLanguage("es");
    $user->setIdChurch($church->getId());

    if (SessionManager::addUser($user))
    {
        echo "OK";
    }
    else
    {
        echo "KO";
    }

 ?>
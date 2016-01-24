<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");

    if (!isset($_POST) || $_POST["bodyMessage"] === NULL)
    {
        die;
    }

    $message = new Message(0, $_POST["bodyMessage"], $_SESSION["user_id"], $_POST["idTo"],
                           0, 1, time());

    SessionManager::addMessage($message);

 ?>
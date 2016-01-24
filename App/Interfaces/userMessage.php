<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('userMessage.php');

    //Get File contest from template
    $string = file_get_contents("template/UserMessage.html");

    //Get All Messages
    $messages = NULL;
    $usernameI = "«" . $_SESSION["user_name"] . "»";
    $usernameO = "";

    if (isset($_GET) && $_GET["id"] !== NULL)
    {
        $userA = SessionManager::getSingleUser('id', $_GET["id"]);

        if ($userA === NULL || $userA->getId () == $_SESSION["user_id"])
        {
            echo "<script>window.location.href = 'userMenu.php'</script>";
        }
        else
        {
            $messages = SessionManager::getConversation($_SESSION["user_id"], $_GET["id"], 10);
            $usernameO = "«" . SessionManager::getSingleUser('id', $_GET["id"])->getUsername() . "»";
        }
    }
    else
    {
        echo "<script>window.location.href = 'userMenu.php'</script>";
    }

    $stringMessage = "";

    if ($messages !== NULL)
    {
        foreach ($messages as $value) 
        {
            if ($value->getIdUserTo() == $_SESSION["user_id"])
            {
                $stringMessage = $stringMessage . "<div class='globo-izq'><strong>";
                $stringMessage = $stringMessage . $usernameO;

                if ($value->getSeen() == '0')
                {
                    $value->setSeen(1);
                    SessionManager::updateMessage($value);
                }
            }
            else
            {
                $stringMessage = $stringMessage . "<div class='globo-der'><strong>";
                $stringMessage = $stringMessage . $usernameI;
            }

            $stringC = "";

            if ($value->getReceived() == '1')
            {
                $stringC = $stringC .'✓';
            }
            else
            {
                $stringC = $stringC .'X';   
            }

            if ($value->getSeen() == '1')
            {
                $stringC = $stringC .'✓ ';   
            }
            else
            {
                $stringC = $stringC .'  ';
            }

            $stringMessage = $stringMessage . " " .date('m/d/y h:i A', $value->getTime()) . "</strong><br>";
            $stringMessage = $stringMessage . $stringC . " " . $value->getContest() . "</div><br>";
        }
    }
    else
    {
        $stringMessage = "<h1> ^No Messages^ </h1>";
    }

    //Replace the Message
    $string = str_replace("|MessagesLastest|", $stringMessage, $string);
    $string = str_replace("|Username|", $usernameO, $string);

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
 ?>
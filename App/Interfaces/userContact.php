<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('userContact.php');

    //Get File contest from template
    $string = file_get_contents("template/UserContact.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Get All Contacts
    $contacts = SessionManager::getContacts(new User($_SESSION["user_id"]));

    $stringContact = "";

    if ($contacts !== NULL)
    {
        foreach ($contacts as $key => $value)
        {
            if ($value->getId () == $_SESSION["user_id"])
            {
                continue;
            }

            $lastMessage = SessionManager::getConversation($value->getId(), $_SESSION["user_id"]);

            $lastMessage = $lastMessage[0];

            $stringC = "";

            if ($lastMessage->getReceived() == '1')
            {
                $stringC = $stringC .'✓';
            }
            else
            {
                $stringC = $stringC .'X';   
            }

            if ($lastMessage->getSeen() == '1')
            {
                $stringC = $stringC .'✓ ';   
            }
            else
            {
                $stringC = $stringC .'  ';
            }

            if ($lastMessage->getIdUserFrom() != $_SESSION["user_id"])
            {
                $stringC = '';
            }

            $stringOnclick = 'href="userMessage.php?id=' . $value->getId() . '"';

            $stringContact = $stringContact . "<a class='list-group-item' $stringOnclick><strong>" . 
                             $value->getUsername() . "</strong> " .
                             date('m/d/y h:i A', $lastMessage->getTime()) . " <br>" . $stringC . 
                             substr($lastMessage->getContest(), 0, 50) . "</a>";
        }
    }

    //Replace the Contact
    $string = str_replace("|tableContacts|", $stringContact, $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
 ?>
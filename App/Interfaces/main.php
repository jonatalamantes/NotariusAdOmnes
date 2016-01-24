<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/BibleQuote.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('main.php');

    //Get File contest from template
    $string = file_get_contents("template/Main.html");

    $string = str_replace("|biblic|", BibleQuote::randomQuote(), $string);

    //Remplace the nav
    $user_name = strtoupper(SessionManager::getCurrentUser()->getUsername());
    $string = str_replace("Username", $user_name, $string);

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
 ?>
<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");

    SessionManager::validateUserInPage('userInsertion.php');

    //Get File contest from template
    $string = file_get_contents("template/UserInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Insert User', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Create a String of options of Last Church
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name');

    foreach ($churchs as $singleChurch) 
    {
        $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
    }

    $string = str_replace("|ChurchOption|", $churchString, $string);

    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("userInsertion.php", "insert")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("userMenu.php")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    $string = str_replace("disabled",       "", $string);

    $string = LanguageSupport::HTMLEvalLanguage($string);

    echo $string;
 ?>
<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/CityManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('cityInsertion.php');

    //Get File Contest
    $string = file_get_contents("template/CityInsertion.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Create a Button State
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("cityInsertion.php", "' . SessionManager::getLastPage() . '")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("' . SessionManager::getLastPage() . '")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    //The select for States
    $stateString = "";
    $states = CityManager::getAllStates();

    foreach ($states as $singleState) 
    {
        $stateString = $stateString . "<option> " . $singleState->getName() . "</option>\n";
    }

    $string = str_replace("|StateOption|", $stateString, $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
 ?>
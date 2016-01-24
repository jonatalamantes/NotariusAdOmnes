<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('addRelationChurchRector.php');

    //Get File contest from template
    $string = file_get_contents("template/AddRelationChurchRector.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Create a String of Church Options
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name', -1);

    foreach ($churchs as $singleChurch) 
    {
        $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
    }

    $string = str_replace("|ChurchOption|", $churchString, $string);

    //Create a String of Rector Options
    $rectorString = "";
    $rectors = RectorManager::getAllRectors('name');

    foreach ($rectors as $singleRector) 
    {
        $idRector = $singleRector->getId();
        $person   = PersonManager::getSinglePerson('id', $idRector);
        $fullname = $person->getFullName();
        $rectorString = $rectorString . "<option lang='$idRector' id='$fullname'> " . $fullname . "</option>\n";
    }

    $string = str_replace("|RectorOption|", $rectorString, $string);

    //Create Button contest
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("addRelationChurchRector.php", "'. SessionManager::getLastPage() .'")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("'. SessionManager::getLastPage() .'")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    $string = LanguageSupport::HTMLEvalLanguage($string);

    echo $string;
 ?>
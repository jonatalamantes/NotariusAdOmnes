<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('rectorInsertion.php');

    //Get File Contest
    $string = file_get_contents("template/RectorInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|", 'Insert Rector', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Create a String of options of Last Church
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name');

    foreach ($churchs as $singleChurch) 
    {
        $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
    }

    $string = str_replace("|OptionChurch|", $churchString, $string);

    //Create a Button Rector
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("rectorInsertion.php", "insert")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("rectorMenu.php")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    //Clean the fields
    $string = str_replace('value="rectorName"',      '', $string);
    $string = str_replace('value="rectorLastname1"', '', $string);
    $string = str_replace('value="rectorLastname2"', '', $string);
    $string = str_replace('value="type"',            '', $string);
    $string = str_replace('value="position"',        '', $string);

    //Enable all the data
    $string = str_replace("disabled", '', $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
 ?>
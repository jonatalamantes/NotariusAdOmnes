<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/CityManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('officeInsertion.php');

    //Get File Contest
    $string = file_get_contents("template/OfficeCivilRegistryInsertion.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Create a String of options of Cities
    $citiesString = "";
    $cities = CityManager::getAllCities();

    foreach ($cities as $singleCity) 
    {
        $citiesString = $citiesString . "<option> " . $singleCity->getName() . "</option>\n";
    }

    $string = str_replace("|CityOptions|", $citiesString, $string);

    //Create a Button State
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("officeInsertion.php", "baptismInsertion.php")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("baptismInsertion.php")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
 ?>
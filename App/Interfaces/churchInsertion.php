<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('churchInsertion.php');

    //Get File contest from template
    $string = file_get_contents("template/ChurchInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|", 'Insert Church', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Create a String of options of Vicars
    $vicarString = "";
    $vicars = ChurchManager::getAllVicars();

    foreach ($vicars as $singleVicar) 
    {
        $vicarString = $vicarString . "<option> " . $singleVicar->getName() . "</option>\n";
    }

    $string = str_replace("|VicarOptions|", $vicarString, $string);

    //Create a String of options of Deans
    $deanString = "";
    $deans = ChurchManager::getAllDeans();

    foreach ($deans as $singleDean) 
    {
        $deanString = $deanString . "<option> " . $singleDean->getName() . "</option>\n";
    }

    $string = str_replace("|DeanOptions|", $deanString, $string);

    //Create a String of options of Cities
    $citiesString = "";
    $cities = CityManager::getAllCities();

    foreach ($cities as $singleCity) 
    {
        $citiesString = $citiesString . "<option> " . $singleCity->getName() . "</option>\n";
    }

    $string = str_replace("|CityOptions|", $citiesString, $string);

    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("churchInsertion.php", "insert")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("churchMenu.php")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    //Clean the fields
    $string = str_replace('value="churchName"',        '', $string);
    $string = str_replace('value="churchType"',        '', $string);
    $string = str_replace('value="churchCode"',        '', $string);
    $string = str_replace('value="churchAddress"',     '', $string);
    $string = str_replace('value="churchColony"',      '', $string);
    $string = str_replace('value="churchPostalCode"',  '', $string);
    $string = str_replace('value="churchPhoneNumber"', '', $string);
    $string = str_replace('value="maxCol"',            '', $string);
    $string = str_replace('value="maxRow"',            '', $string);
    $string = str_replace('value="size"',              '', $string);

    //Enable all the data
    $string = str_replace("disabled", '', $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
 ?>
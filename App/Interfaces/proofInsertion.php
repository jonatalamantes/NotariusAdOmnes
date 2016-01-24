<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ProofManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('proofInsertion.php');

    //Get File contest from template
    $string = file_get_contents("template/ProofInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Insert Proof', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Create a String of options of Last Church
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name');

    foreach ($churchs as $singleChurch) 
    {
        if ($singleChurch->getId() == $_SESSION["user_church"])
        {
            $churchString = $churchString . "<option selected> " . $singleChurch->getName() . "</option>\n";
        }
        else
        {
            $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
        }
    }

    $string = str_replace("|ChurchOption|", $churchString, $string);

    //Create a String of options of Cities
    $citiesString = "";
    $cities = CityManager::getAllCities();

    $idCity = "7";

    foreach ($cities as $singleCity) 
    {
        if ($idCity === $singleCity->getId())
        {
            $citiesString = $citiesString . "<option selected> " . $singleCity->getName() . "</option>\n";
        }
        else
        {
            $citiesString = $citiesString . "<option> " . $singleCity->getName() . "</option>\n";
        }
    }

    $string = str_replace("|CityOptions|", $citiesString, $string);

    //Insert The Type of Proof
    $stringProof = "";

    $stringProof = $stringProof . "<option>^Baptism^</option>";
    $stringProof = $stringProof . "<option>^Communion^</option>";
    $stringProof = $stringProof . "<option>^Confirmation^</option>";
    $stringProof = $stringProof . "<option>^XV^</option>";

    $string = str_replace("|TypeOptions|", $stringProof, $string);    

    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("proofInsertion.php", "insert")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("proofMenu.php")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    $string = str_replace("disabled",       "", $string);
    $string = str_replace("|isFemale|",     "", $string);
    $string = str_replace("|isLegitimate|", "", $string);

    $string = LanguageSupport::HTMLEvalLanguage($string);
    $string = SessionManager::permisionTag($string);

    echo $string;

    if ($_SESSION["user_type"] != 'A') //is G
    {
        echo "<script>
                $('#church').attr('disabled', 'true');
                $('#btnAddChurch').attr('disabled', 'true');
                $('#btnAddRelation1').attr('disabled', 'true');
                $('#btnCity').attr('disabled', 'true');
             </script>";
    }
 ?>
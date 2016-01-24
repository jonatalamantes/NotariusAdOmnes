<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('baptismInsertion.php');

    //Get File contest from template
    $string = file_get_contents("template/BaptismInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Insert Baptism', $string);
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

    //Create a String of options of Civil Registries
    $civilString = "";
    $civilRegis  = BaptismManager::getAllOfficeCivilRegistries();

    foreach ($civilRegis as $single) 
    {
        $city = CityManager::getSingleCity('id', $single->getIdCity())->getName();

        $civilString = $civilString . "<option> No. " . $single->getNumber() . 
                                      ", $city.</option>\n";
    }

    $string = str_replace("|CivilRegistryOption|", $civilString, $string);

    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("baptismInsertion.php", "insert")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("baptismMenu.php")\'>
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
                $('#btnAddRector').attr('disabled', 'true');
                $('#btnAddRelation2').attr('disabled', 'true');

             </script>";
    }

    echo "<script>getFormerRector();</script>";

 ?>
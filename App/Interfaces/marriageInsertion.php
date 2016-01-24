<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('marriageInsertion.php');

    //Get File contest from template
    $string = file_get_contents("template/MarriageInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Insert Marriage', $string);
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

    $string = str_replace("|ChurchOptionMarriage|", $churchString, $string);
    $string = str_replace("|ChurchOptionProcess|", $churchString, $string);


    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("marriageInsertion.php", "insert")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("marriageMenu.php")\'>
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
    $string = SessionManager::permisionTag($string);

    echo $string;

    if ($_SESSION["user_type"] != 'A') //is G
    {
        echo "<script>
                $('#church').attr('disabled', 'true');
                $('#btnAddChurch1').attr('disabled', 'true');
                $('#btnAddRelation1').attr('disabled', 'true');
                $('#btnAddRector').attr('disabled', 'true');
                $('#btnAddRelation2').attr('disabled', 'true');
                $('#btnAddRelation3').attr('disabled', 'true');
                $('#btnAddChurch2').attr('disabled', 'true');
             </script>";
    }

    echo "<script>getFormerRector();</script>";

 ?>
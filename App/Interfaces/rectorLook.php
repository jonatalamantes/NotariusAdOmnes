<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('rectorLook.php');

    //Get File contest from template
    $string = file_get_contents("template/RectorInsertion.html");

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    //Remplace the nav
    $string = str_replace("|title|", 'Look Rector', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    $idRector = $_GET["id"];
    $rector   = RectorManager::getSingleRector('id', $idRector);

    if ($rector === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('rectorMenu.php')</script>";
    }

    //Create a String of options of Last Church
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name');

    foreach ($churchs as $singleChurch) 
    {
        if ($rector->getIdActualChurch() == $singleChurch->getId())
        {
            $churchString = $churchString . "<option selected> " . $singleChurch->getName() . "</option>\n";
        }
        else
        {
            $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";   
        }
    }

    $string = str_replace("|OptionChurch|", $churchString, $string);


    //Create Button Contest
    $saveButton   = '';

    $cancelButton = '';

    $returnButton = '<button type="button" class="btn btn-success" onclick=\'href("rectorMenu.php")\'>
                        <img src="../icons/return.png" width="50px"><br>
                        <strong>^Return^</strong>
                    </button>';

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    //Clean the fields
    $person = PersonManager::getSinglePerson('id', $rector->getIdPerson());

    $string = str_replace('value="rectorName"',      'value="'.$person->getNames().'"',     $string);
    $string = str_replace('value="rectorLastname1"', 'value="'.$person->getLastname1().'"', $string);
    $string = str_replace('value="rectorLastname2"', 'value="'.$person->getLastname2().'"', $string);
    $string = str_replace('value="type"',            'value="'.$rector->getType().'"',      $string);
    $string = str_replace('value="position"',        'value="'.$rector->getPosition().'"',  $string);

    if ($rector->getStatus() === 'A')
    {
        $string = str_replace('|selected|', '', $string);
    }
    else
    {
        $string = str_replace('|selected|', 'selected', $string);
    }

    //Display the page    
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;

 ?>
<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/DefuntionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    //Get File contest from template
    $string = file_get_contents("template/DefuntionInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|", 'Change Defuntion', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Get The Data of the Defuntion
    $idDefuntion       = $_GET["id"];
    $defuntion         = DefuntionManager::getSingleDefuntion('id', $idDefuntion);

    $ownerId           = $defuntion->getIdOwner();
    $owner             = PersonManager::getSinglePerson('id', $ownerId);

    $churchId          = $defuntion->getIdChurch();
    SessionManager::validateUserInPage('defuntionChange.php', $churchId);

    $defuntionDate     = DatabaseManager::databaseDateToSingleDate($defuntion->getDeadDate());

    //Create a String of options of Last Church
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name');

    foreach ($churchs as $singleChurch) 
    {
        if ($singleChurch->getId() === $churchId)
        {
            $churchString = $churchString . "<option selected> " . $singleChurch->getName() . "</option>\n";
        }
        else
        {
            $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
        }
    }

    $string = str_replace("|ChurchOption|", $churchString, $string);

    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("defuntionInsertion.php", "update")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("defuntionMenu.php")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);
    $string = str_replace("disabled", "", $string);


    //Recuperamos la iglesia
    $church = ChurchManager::getSingleChurch('id', $churchId);

    if ($church !== NULL)
    {
        if ($church->getIdNiche() !== NULL)
        {
            if ($defuntion->getIdCrypt() !== NULL)
            {
                $cryptData = DefuntionManager::getSingleCrypt('id', $defuntion->getIdCrypt());

                //Load Crypt Data
                $string = str_replace('value="col"',  'value="' . $cryptData->getCol()  . '"', $string);
                $string = str_replace('value="row"',  'value="' . $cryptData->getRow()  . '"', $string);
                $string = str_replace('value="size"', 'value="' . $cryptData->getNumber() . '"', $string);

                $idCrypt = $defuntion->getIdCrypt();

                //Display the page
                $string = LanguageSupport::HTMLEvalLanguage($string);
                $string = SessionManager::permisionTag($string);
                echo $string;

                //put the data of the crypt
                echo "<script>
                        document.getElementById('inputCrypt').checked = true;
                        checkCrypt();
                        $('#idCrypt').html('$idCrypt');
                      </script>";
            }
            else
            {
                //Display the page
                $string = LanguageSupport::HTMLEvalLanguage($string);
                $string = SessionManager::permisionTag($string);
                echo $string;
            }
        }
        else
        {
            //Display the page
            $string = LanguageSupport::HTMLEvalLanguage($string);
            $string = SessionManager::permisionTag($string);
            echo $string;

            echo "<script>
                    hiddenElement('cryptlabel', 'true');
                    hiddenElement('crypts', 'true');
                    document.getElementById('inputCrypt').checked = false; checkCrypt();
                  </script>";
        }
    }
    else
    {
        //Display the page
        $string = LanguageSupport::HTMLEvalLanguage($string);
        $string = SessionManager::permisionTag($string);
        echo $string;
    }

    $script = "<script>
        $('#idDefuntion').html('$idDefuntion');

        parentIdPerson('$ownerId', '0', '0', 'child', 'self');
        $('#childDefuntionDate').val('$defuntionDate');
      </script>";

    echo $script;

    if ($_SESSION["user_type"] != 'A') //is G
    {
        echo "<script>
                $('#church').attr('disabled', 'true');
                $('#btnAddChurch').attr('disabled', 'true');
                $('#btnAddRelation1').attr('disabled', 'true');
             </script>";
    }

 ?>
<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ProofManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    //Get File contest from template
    $string = file_get_contents("template/ProofInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Change Proof', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Get The Data of the Proof
    $idProof       = $_GET["id"];
    $proof         = ProofManager::getSingleProofTalks('id', $idProof);

    $ownerId         = $proof->getIdOwner();
    $owner           = PersonManager::getSinglePerson('id', $ownerId);
    $owner->getIdFather() !== NULL ? $fatherId = $owner->getIdFather() : $fatherId = 0;
    $owner->getIdMother() !== NULL ? $motherId = $owner->getIdMother() : $motherId = 0; 
    $address         = $owner->getAddress();
    $phonenum        = $owner->getPhoneNumber();
    $gender          = $owner->getGender();

    $churchId        = $proof->getIdChurch();
    SessionManager::validateUserInPage('proofChange.php', $churchId);

    $idGodFather     = $proof->getIdGodFather();
    $idGodMother     = $proof->getIdGodMother();
    $godMother       = PersonManager::getSinglePerson('id', $idGodMother);
    $godFather       = PersonManager::getSinglePerson('id', $idGodFather);

    if ($godFather === NULL)
    {
        $godFather = new Person();
    }

    if ($godMother === NULL)
    {
        $godMother = new Person();
    }

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

    //Create a String of options of Cities
    $citiesString = "";
    $cities = CityManager::getAllCities();

    $idCity = "7";

    if ($owner->getIdCityAddress() !== NULL)
    {   
        $idCity = $owner->getIdCityAddress();
    }   

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

    //Insert the Type Proof
    $stringProof = "";

    if ($proof->getType() === 'C')
    {
        $stringProof = $stringProof . "<option>^Baptism^</option>";
        $stringProof = $stringProof . "<option>^Communion^</option>";
        $stringProof = $stringProof . "<option selected>^Confirmation^</option>";
        $stringProof = $stringProof . "<option>^XV^</option>";
    }
    else if ($proof->getType() === 'X')
    {
        $stringProof = $stringProof . "<option>^Baptism^</option>";
        $stringProof = $stringProof . "<option>^Communion^</option>";
        $stringProof = $stringProof . "<option>^Confirmation^</option>";
        $stringProof = $stringProof . "<option selected>^XV^</option>";
    }
    else if ($proof->getType() === 'C')
    {
        $stringProof = $stringProof . "<option>^Baptism^</option>";
        $stringProof = $stringProof . "<option selected>^Communion^</option>";
        $stringProof = $stringProof . "<option>^Confirmation^</option>";
        $stringProof = $stringProof . "<option>^XV^</option>";
    }
    else
    {
        $stringProof = $stringProof . "<option>^Baptism^</option>";
        $stringProof = $stringProof . "<option>^Communion^</option>";
        $stringProof = $stringProof . "<option>^Confirmation^</option>";
        $stringProof = $stringProof . "<option>^XV^</option>";
    }

    $string = str_replace("|TypeOptions|", $stringProof, $string);    

    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("proofInsertion.php", "update")\'>
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
    $string = str_replace("disabled", "", $string);

    $script = "<script>
            $('#idProof').html('$idProof');

            parentIdPerson('$ownerId', '$fatherId', '$motherId', 'child', 'self');
            $('#childPhone').val('$phonenum');
            $('#childAddress').val('$address');

            if ('" . $godFather->getNames() . "' == '')
            {
                hiddenElement('panel-body-godfather', 'true'); 
                hiddenElement('btnHideGodFather', 'true', 'inline'); 
                hiddenElement('btnShowGodFather', 'false', 'inline');
            }
            else
            {
                $('#godfatherName').val('" . $godFather->getNames() . "');
                $('#godfatherLastname1').val('" . $godFather->getLastname1() . "');
                $('#godfatherLastname2').val('" . $godFather->getLastname2() . "');
            }

            if ('" . $godMother->getNames() . "' == '')
            {
                hiddenElement('panel-body-godmother', 'true'); 
                hiddenElement('btnHideGodMother', 'true', 'inline'); 
                hiddenElement('btnShowGodMother', 'false', 'inline');
            }
            else
            {
                $('#godmotherName').val('" . $godMother->getNames() . "');
                $('#godmotherLastname1').val('" . $godMother->getLastname1() . "');
                $('#godmotherLastname2').val('" . $godMother->getLastname2() . "');
            }

          </script>";

    $string = LanguageSupport::HTMLEvalLanguage($string);
    $string = SessionManager::permisionTag($string);

    echo $string;
    echo $script;

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
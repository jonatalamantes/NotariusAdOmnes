<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ConfirmationManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");

    //Get File contest from template
    $string = file_get_contents("template/ConfirmationInsertion.html");

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    //Remplace the nav
    $string = str_replace("|title|",  'Change Confirmation', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Get The Data of the Confirmation
    $idConfirmation       = $_GET["id"];
    $confirmation         = ConfirmationManager::getSingleConfirmation('id', $idConfirmation);

    $ownerId         = $confirmation->getIdOwner();
    $owner           = PersonManager::getSinglePerson('id', $ownerId);
    $owner->getIdFather() !== NULL ? $fatherId = $owner->getIdFather() : $fatherId = 0;
    $owner->getIdMother() !== NULL ? $motherId = $owner->getIdMother() : $motherId = 0;
    $gender          = $owner->getGender();

    $churchId        = $confirmation->getIdChurch();
    $confirmationDate     = DatabaseManager::databaseDateToSingleDate($confirmation->getCelebrationDate());

    SessionManager::validateUserInPage('confirmationChange.php', $churchId);

    $idRector        = $confirmation->getIdRector();
    $objRector       = RectorManager::getSingleRector('id', $idRector);
    $objPerRect      = PersonManager::getSinglePerson('id', $objRector->getIdPerson());
    $nameRector      = $objPerRect->getFullNameBeginName();

    $idBookRegistry  = $confirmation->getIdBookRegistry();
    $bookRegistry    = ConfirmationManager::getSingleConfirmationRegistry('id', $idBookRegistry);

    $idGodFather     = $confirmation->getIdGodFather();
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
    
//Get the Baptism Data
    $baptism = BaptismManager::getSingleBaptism('idOwner', $ownerId);
    
    if ($baptism !== NULL)
    {
        //Create the String for Churchs of Baptism
        $churchString = "<option>XXXXXXXXXX</option>";
        $churchId     = $baptism->getIdChurch();
        $baptismId    = $baptism->getId();
        
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
    
        $string = str_replace("|ChurchOptionB|", $churchString, $string);   
        
        $idBookRegistryB  = $baptism->getIdBookRegistry();
        $bookRegistryB    = BaptismManager::getSingleBaptismRegistry('id', $idBookRegistryB);
    
        $baptismDate = DatabaseManager::databaseDateToSingleDate($baptism->getCelebrationDate());
        $baptismBook = $bookRegistryB->getBook();
        $baptismPage = $bookRegistryB->getPage();
        $baptismNumber = $bookRegistryB->getNumber();
    }
    else
    {
        $churchString = "<option selected>XXXXXXXXXX</option>";
        $baptismId    = 0;
        
        foreach ($churchs as $singleChurch) 
        {
            $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
        }
    
        $string = str_replace("|ChurchOptionB|", $churchString, $string);   
        
        $baptismDate = "";
        $baptismBook = "";
        $baptismPage = "";
        $baptismNumber = "";        
    }

    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("confirmationInsertion.php", "update")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("confirmationMenu.php")\'>
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
            $('#idConfirmation').html('$idConfirmation');
            $('#idBaptism').html('$baptismId');

            parentIdPerson('$ownerId', '$fatherId', '$motherId', 'child', 'self');
            $('#childConfirmationDate').val('$confirmationDate');

            $('#godfatherName').val('" . $godFather->getNames() . "');
            $('#godfatherLastname1').val('" . $godFather->getLastname1() . "');
            $('#godfatherLastname2').val('" . $godFather->getLastname2() . "');

            $('#bookregistryNumber').val('" . $bookRegistry->getNumber() . "');
            $('#bookregistryPage').val('" . $bookRegistry->getPage() . "');
            $('#bookregistryBook').val('" . $bookRegistry->getBook() . "');
            $('#idChurchRegistry').val('" . $bookRegistry->getId() . "');
            
            $('#baptismDate').val('" . $baptismDate . "');
            $('#bookregistryBookBaptism').val('" . $baptismBook . "');
            $('#bookregistryPageBaptism').val('" . $baptismPage . "');
            $('#bookregistryNumberBaptism').val('" . $baptismNumber . "');
            
            getFormerRector('$nameRector', '$idRector');          
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
                $('#btnAddRector').attr('disabled', 'true');
                $('#btnAddRelation2').attr('disabled', 'true');

             </script>";
    }

 ?>
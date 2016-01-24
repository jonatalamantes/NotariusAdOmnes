<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('baptismLook.php');
    
    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    //Get File contest from template
    $string = file_get_contents("template/BaptismInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Look Baptism', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Get The Data of the Baptism
    $idBaptism       = $_GET["id"];
    $baptism         = BaptismManager::getSingleBaptism('id', $idBaptism);

    $ownerId         = $baptism->getIdOwner();
    $owner           = PersonManager::getSinglePerson('id', $ownerId);
    $owner->getIdFather() !== NULL ? $fatherId = $owner->getIdFather() : $fatherId = 0;
    $owner->getIdMother() !== NULL ? $motherId = $owner->getIdMother() : $motherId = 0; 
    $gender          = $owner->getGender();

    $churchId        = $baptism->getIdChurch();
    $bornDate        = DatabaseManager::databaseDateToSingleDate($baptism->getBornDate());
    $bornPlace       = $baptism->getBornPlace();
    $baptismDate     = DatabaseManager::databaseDateToSingleDate($baptism->getCelebrationDate());

    $idRector        = $baptism->getIdRector();
    $objRector       = RectorManager::getSingleRector('id', $idRector);
    $objPerRect      = PersonManager::getSinglePerson('id', $objRector->getIdPerson());
    $nameRector      = $objPerRect->getFullNameBeginName();

    $idCivilRegistry = $baptism->getIdCivilRegistry();
    $civil           = BaptismManager::getSingleCivilRegistry('id', $idCivilRegistry);
    $office          = BaptismManager::getSingleOfficeCivilRegistry('id', $civil->getIdOffice());

    $idBookRegistry  = $baptism->getIdBookRegistry();
    $bookRegistry    = BaptismManager::getSingleBaptismRegistry('id', $idBookRegistry);

    $idGodFather     = $baptism->getIdGodFather();
    $idGodMother     = $baptism->getIdGodMother();
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

    //Create a String of options of Civil Registries
    $civilString = "";
    $civilRegis  = BaptismManager::getAllOfficeCivilRegistries();

    foreach ($civilRegis as $single) 
    {
        $city = CityManager::getSingleCity('id', $single->getIdCity())->getName();

        if ($office->getId() === $single->getId())
        {
            $civilString = $civilString . "<option selected> No. " . $single->getNumber() . 
                                      ", $city.</option>\n";

        }
        else
        {
            $civilString = $civilString . "<option> No. " . $single->getNumber() . 
                                      ", $city.</option>\n";
        }
    }

    $string = str_replace("|CivilRegistryOption|", $civilString, $string);

    if ($baptism->getLegitimate() !== 'Y')
    {
        $string = str_replace("|isLegitimate|", "selected", $string);
    }
    else
    {
        $string = str_replace("|isLegitimate|", "", $string);
    }

    if ($owner->getGender() !== 'M')
    {
        $string = str_replace("|isFemale|", "selected", $string);
    }
    else
    {
        $string = str_replace("|isFemale|", "", $string);
    }

    if ($bookRegistry->getReverse() === 'Y')
    {
        $string = str_replace("|isntReverse|", "", $string);
    }
    else
    {
        $string = str_replace("|isntReverse|", "selected", $string);
    }

    //Create the button
    $saveButton   = '<button type="button" class="btn btn-success" onclick=\'window.open("cert/baptismCert.php?idBaptism='.$idBaptism.'&full=true", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Baptism Cert^<br>^Full^</strong>
                    </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'window.open("cert/baptismCert.php?idBaptism='.$idBaptism.'&full=false", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Baptism Cert^<br>^To Print^</strong>
                    </button>';

    $returnButton = '<button type="button" class="btn btn-success" onclick=\'href("baptismMenu.php")\'>
                        <img src="../icons/return.png" width="70px"><br>
                        <strong>^Return^</strong>
                    </button>'.

                    '<button type="button" class="btn btn-success" onclick=\'window.open("cert/copyBaptismCert.php?idBaptism='.$idBaptism.'&full=true", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Copy Baptism Cert^<br>^Full^</strong>
                    </button>' .

                    '<button type="button" class="btn btn-success" onclick=\'window.open("cert/copyBaptismCert.php?idBaptism='.$idBaptism.'&full=false", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Copy Baptism Cert^<br>^To Print^</strong>
                    </button>'

                    ;

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    $script = "<script>
            $('#idBaptism').html('$idBaptism');

            parentIdPerson('$ownerId', '$fatherId', '$motherId', 'child', 'self');
            $('#childBornDate').val('$bornDate');
            $('#childBornPlace').val('$bornPlace');
            $('#childBaptismDate').val('$baptismDate');

            $('#godfatherName').val('" . $godFather->getNames() . "');
            $('#godfatherLastname1').val('" . $godFather->getLastname1() . "');
            $('#godfatherLastname2').val('" . $godFather->getLastname2() . "');

            $('#godmotherName').val('" . $godMother->getNames() . "');
            $('#godmotherLastname1').val('" . $godMother->getLastname1() . "');
            $('#godmotherLastname2').val('" . $godMother->getLastname2() . "');

            $('#civilregistryNumber').val('" . $civil->getNumber() . "');
            $('#civilregistryPage').val('" . $civil->getPage() . "');
            $('#civilregistryBook').val('" . $civil->getBook() . "');
            $('#idCivilRegistry').val('" . $civil->getId() . "');

            $('#bookregistryNumber').val('" . $bookRegistry->getNumber() . "');
            $('#bookregistryPage').val('" . $bookRegistry->getPage() . "');
            $('#bookregistryBook').val('" . $bookRegistry->getBook() . "');
            $('#idChurchRegistry').val('" . $bookRegistry->getId() . "');
            
            getFormerRector('$nameRector', '$idRector');
          </script>";

    $string = LanguageSupport::HTMLEvalLanguage($string);
    $string = SessionManager::permisionTag($string);

    echo $string;
    echo $script;

 ?>
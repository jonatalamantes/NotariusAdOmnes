<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/CommunionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('communionLook.php');

    //Get File contest from template
    $string = file_get_contents("template/CommunionInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Look Communion', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    //Get The Data of the Communion
    $idCommunion       = $_GET["id"];
    $communion         = CommunionManager::getSingleCommunion('id', $idCommunion);

    $ownerId         = $communion->getIdOwner();
    $owner           = PersonManager::getSinglePerson('id', $ownerId);
    $owner->getIdFather() !== NULL ? $fatherId = $owner->getIdFather() : $fatherId = 0;
    $owner->getIdMother() !== NULL ? $motherId = $owner->getIdMother() : $motherId = 0;
    $gender          = $owner->getGender();

    $churchId        = $communion->getIdChurch();
    $communionDate     = DatabaseManager::databaseDateToSingleDate($communion->getCelebrationDate());

    $idRector        = $communion->getIdRector();
    $objRector       = RectorManager::getSingleRector('id', $idRector);
    $objPerRect      = PersonManager::getSinglePerson('id', $objRector->getIdPerson());
    $nameRector      = $objPerRect->getFullNameBeginName();

    $idBookRegistry  = $communion->getIdBookRegistry();
    $bookRegistry    = CommunionManager::getSingleCommunionRegistry('id', $idBookRegistry);

    $idGodFather     = $communion->getIdGodFather();
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

    //Create the button
    $saveButton   = '<button type="button" class="btn btn-success" onclick=\'window.open("cert/communionCert.php?idCommunion='.$idCommunion.'&full=true", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Communion Cert^<br>^Full^</strong>
                    </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'window.open("cert/communionCert.php?idCommunion='.$idCommunion.'&full=false", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Communion Cert^<br>^To Print^</strong>
                    </button>';

    $returnButton = '<button type="button" class="btn btn-success" onclick=\'href("communionMenu.php")\'>
                        <img src="../icons/return.png" width="70px"><br>
                        <strong>^Return^</strong>
                    </button>'.

                    '<button type="button" class="btn btn-success" onclick=\'window.open("cert/copyCommunionCert.php?idCommunion='.$idCommunion.'&full=true", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Copy Communion Cert^<br>^Full^</strong>
                    </button>' .

                    '<button type="button" class="btn btn-success" onclick=\'window.open("cert/copyCommunionCert.php?idCommunion='.$idCommunion.'&full=false", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Copy Communion Cert^<br>^To Print^</strong>
                    </button>'

                    ;

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    $script = "<script>
            $('#idCommunion').html('$idCommunion');

            parentIdPerson('$ownerId', '$fatherId', '$motherId', 'child', 'self');
            $('#childCommunionDate').val('$communionDate');

            $('#godfatherName').val('" . $godFather->getNames() . "');
            $('#godfatherLastname1').val('" . $godFather->getLastname1() . "');
            $('#godfatherLastname2').val('" . $godFather->getLastname2() . "');

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
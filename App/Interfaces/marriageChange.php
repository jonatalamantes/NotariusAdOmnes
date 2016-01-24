<?php 
    
    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    //Get File contest from template
    $string = file_get_contents("template/MarriageInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|",  'Change Marriage', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Get The Data of the Marriage
    $idMarriage       = $_GET["id"];
    $marriage         = MarriageManager::getSingleMarriage('id', $idMarriage);

    $boyfriendId     = $marriage->getIdBoyfriend();
    $boyfriend       = PersonManager::getSinglePerson('id', $boyfriendId);

    $girlfriendId    = $marriage->getIdGirlfriend();
    $girlfriend      = PersonManager::getSinglePerson('id', $girlfriendId);

    $churchMarriageId = $marriage->getIdChurchMarriage();
    $churchProcessId  = $marriage->getIdChurchProcess();
    $marriageDate     = DatabaseManager::databaseDateToSingleDate($marriage->getCelebrationDate());

    SessionManager::validateUserInPage('marriageChange.php', $churchMarriageId, $churchProcessId);

    $idRector        = $marriage->getIdRector();
    $objRector       = RectorManager::getSingleRector('id', $idRector);
    $objPerRect      = PersonManager::getSinglePerson('id', $objRector->getIdPerson());
    $nameRector      = $objPerRect->getFullNameBeginName();

    $idBookRegistry  = $marriage->getIdBookRegistry();
    $bookRegistry    = MarriageManager::getSingleMarriageRegistry('id', $idBookRegistry);

    $idGodFather     = $marriage->getIdGodFather();
    $idGodMother     = $marriage->getIdGodMother();
    $godMother       = PersonManager::getSinglePerson('id', $idGodMother);
    $godFather       = PersonManager::getSinglePerson('id', $idGodFather);

    $idWitness1      = $marriage->getIdWitness1();
    $idWitness2      = $marriage->getIdWitness2();
    $witness1        = PersonManager::getSinglePerson('id', $idWitness1);
    $witness2        = PersonManager::getSinglePerson('id', $idWitness2);

    if ($godFather === NULL)
    {
        $godFather = new Person();
    }

    if ($godMother === NULL)
    {
        $godMother = new Person();
    }

    if ($witness1 === NULL)
    {
        $witness1 = new Person();
    }

    if ($witness2 === NULL)
    {
        $witness2 = new Person();
    }

    //Create a String of options of Last Church
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name');

    foreach ($churchs as $singleChurch) 
    {
        if ($singleChurch->getId() === $churchProcessId)
        {
            $churchString = $churchString . "<option selected> " . $singleChurch->getName() . "</option>\n";
        }
        else
        {
            $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
        }
    }

    $string = str_replace("|ChurchOptionProcess|", $churchString, $string);

    //Create a String of options of Last Church
    $churchString = "";
    $churchs = ChurchManager::getAllChurchs('name');

    foreach ($churchs as $singleChurch) 
    {
        if ($singleChurch->getId() === $churchMarriageId)
        {
            $churchString = $churchString . "<option selected> " . $singleChurch->getName() . "</option>\n";
        }
        else
        {
            $churchString = $churchString . "<option> " . $singleChurch->getName() . "</option>\n";
        }
    }

    $string = str_replace("|ChurchOptionMarriage|", $churchString, $string);

    if ($bookRegistry->getReverse() === 'Y')
    {
        $string = str_replace("|isntReverse|", "", $string);
    }
    else
    {
        $string = str_replace("|isntReverse|", "selected", $string);
    }

    //Create the button
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("marriageInsertion.php", "update")\'>
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

    $string = str_replace("disabled", "", $string);

    $script = "<script>
            $('#idMarriage').html('$idMarriage');
            $('#idBoyfriend').html('$boyfriendId');
            $('#idGirlfriend').html('$boyfriendId');

            parentIdPerson('$boyfriendId', '0', '0', 'boyfriend', 'self');
            parentIdPerson('$girlfriendId', '0', '0', 'girlfriend', 'self');
            $('#marriageDate').val('$marriageDate');

            $('#godfatherName').val('" . $godFather->getNames() . "');
            $('#godfatherLastname1').val('" . $godFather->getLastname1() . "');
            $('#godfatherLastname2').val('" . $godFather->getLastname2() . "');

            $('#godmotherName').val('" . $godMother->getNames() . "');
            $('#godmotherLastname1').val('" . $godMother->getLastname1() . "');
            $('#godmotherLastname2').val('" . $godMother->getLastname2() . "');

            $('#witness1Name').val('" . $witness1->getNames() . "');
            $('#witness1Lastname1').val('" . $witness1->getLastname1() . "');
            $('#witness1Lastname2').val('" . $witness1->getLastname2() . "');

            $('#witness2Name').val('" . $witness2->getNames() . "');
            $('#witness2Lastname1').val('" . $witness2->getLastname1() . "');
            $('#witness2Lastname2').val('" . $witness2->getLastname2() . "');

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

 ?>
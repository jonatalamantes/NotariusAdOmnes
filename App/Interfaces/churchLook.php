<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('churchLook.php');

    //Get File contest from template
    $string = file_get_contents("template/ChurchInsertion.html");

    //Remplace the nav
    $string = str_replace("|title|", 'Look Church', $string);
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('main.php')</script>";
    }

    $idChurch = $_GET["id"];
    $church   = ChurchManager::getSingleChurch('id', $idChurch);

    if ($church === NULL)
    {
        echo "<script src='../JS/functions.js'></script><script>href('churchMenu.php')</script>";
    }

    //Create a String of options of Vicars
    $vicarString = "";
    $vicars = ChurchManager::getAllVicars();

    foreach ($vicars as $singleVicar) 
    {
        if ($church->getIdVicar() === $singleVicar->getId())
        {
            $vicarString = $vicarString . "<option selected> " . $singleVicar->getName() . "</option>\n";
        }
        else
        {
            $vicarString = $vicarString . "<option> " . $singleVicar->getName() . "</option>\n";
        }
    }

    $string = str_replace("|VicarOptions|", $vicarString, $string);

    //Create a String of options of Deans
    $deanString = "";
    $deans = ChurchManager::getAllDeans();

    foreach ($deans as $singleDean) 
    {
        if ($church->getIdDean() === $singleDean->getId())
        {
            $deanString = $deanString . "<option selected> " . $singleDean->getName() . "</option>\n";
        }
        else
        {
            $deanString = $deanString . "<option> " . $singleDean->getName() . "</option>\n";
        }
    }

    $string = str_replace("|DeanOptions|", $deanString, $string);

    //Create a String of options of Cities
    $citiesString = "";
    $cities = CityManager::getAllCities();

    foreach ($cities as $singleCity) 
    {
        if ($church->getIdCity() === $singleCity->getId())
        {
            $citiesString = $citiesString . "<option selected> " . $singleCity->getName() . "</option>\n";
        }
        else
        {
            $citiesString = $citiesString . "<option> " . $singleCity->getName() . "</option>\n";
        }
    }

    $string = str_replace("|CityOptions|", $citiesString, $string);

    $saveButton   = '<button type="button" class="btn btn-success" onclick=\'window.open("cert/envelopeChurch.php?idChurch='.$idChurch.'", "new")\'>
                        <img src="../icons/print.png" width="50px"><br>
                        <strong>^Envelope Church^</strong>
                    </button> ';

    $cancelButton = '';

    $returnButton = '<button type="button" class="btn btn-success" onclick=\'href("churchMenu.php")\'>
                        <img src="../icons/return.png" width="50px"><br>
                        <strong>^Return^</strong>
                    </button>';

    //Create a action for button cancel
    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    //Clean the fields
    $string = str_replace('value="churchName"',        'value="' . $church->getName() . '"',        $string);
    $string = str_replace('value="churchType"',        'value="' . $church->getType() . '"',        $string);
    $string = str_replace('value="churchCode"',        'value="' . $church->getCode() . '"',        $string);
    $string = str_replace('value="churchAddress"',     'value="' . $church->getAddress() . '"',     $string);
    $string = str_replace('value="churchColony"',      'value="' . $church->getColony() . '"',      $string);
    $string = str_replace('value="churchPostalCode"',  'value="' . $church->getPostalCode() . '"',  $string);
    $string = str_replace('value="churchPhoneNumber"', 'value="' . $church->getPhoneNumber() . '"', $string);

    if ($church->getIdNiche() !== NULL)
    {
        $nicheData = ChurchManager::getSingleNiche('id', $church->getidNiche());

        //Load Niche Data
        $string = str_replace('value="maxCol"', 'value="' . $nicheData->getMaxCol()  . '"', $string);
        $string = str_replace('value="maxRow"', 'value="' . $nicheData->getMaxRow()  . '"', $string);
        $string = str_replace('value="size"',   'value="' . $nicheData->getSize() . '"', $string);

        //Display the page
        $string = LanguageSupport::HTMLEvalLanguage($string);
        echo $string;

        //put the data of the niche
        echo "<script>document.getElementById('inputNiche').checked = true; checkNiche();</script>";
    }
    else
    {
        //Display the page
        $string = LanguageSupport::HTMLEvalLanguage($string);
        echo $string;
    }

 ?>
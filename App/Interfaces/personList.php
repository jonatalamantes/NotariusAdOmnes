<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    $string = file_get_contents("template/PersonList.html");

    $name      = $_GET["name"];
    $lastname1 = $_GET["lastname1"];
    $lastname2 = $_GET["lastname2"];

    $posiblePerson = PersonManager::searchPersonsByNames($name, $lastname1, $lastname2);
    $personList = "";

    if ($posiblePerson !== NULL)
    {
        foreach ($posiblePerson as $singlePerson) 
        {
            $father = PersonManager::getSinglePerson('id', $singlePerson->getIdFather());
            $mother = PersonManager::getSinglePerson('id', $singlePerson->getIdMother());

            $nameChild  = $singlePerson->getNames() . ' ' . 
                          $singlePerson->getLastname1() . ' ' . 
                          $singlePerson->getLastname2();
            
            $nameFather = "^Not Father^";
            $nameMother = "^Not Mother^";
            $idString = '"' . $singlePerson->getId() . '",';

            if ($father !== NULL)
            {
                $nameFather = $father->getNames() . ' ' . 
                              $father->getLastname1() . ' ' . 
                              $father->getLastname2();

                $idString = $idString . '"' . $father->getId() . '",';
            }
            else
            {
                $idString = $idString . '"0",';
            }

            if ($mother !== NULL)
            {
                $nameMother = $mother->getNames() . ' ' . 
                              $mother->getLastname1() . ' ' . 
                              $mother->getLastname2();

                $idString = $idString . '"' . $mother->getId() . '",';
            }
            else
            {
                $idString = $idString . '"0",';
            }
            
            $idString = $idString . '"' . $_GET["type"] . '"';

            $personList = $personList . "<tr class='selectedTable' onclick='parentIdPerson($idString)'>\n
                           <td>\n\t" .
                           $nameChild . "<br>" . 
                           "^Father^:\t" . $nameFather . "<br>" . 
                           "^Mother^:\t" . $nameMother .
                           "</td></tr>\n";
        } 
    }

    $personList = $personList . "<tr class='selectedTable' onclick='parentIdPerson(\"0\", \"0\", \"0\", \"" . $_GET["type"] . "\")'>\n<td>\n\t^Isn't Here^</td></tr>\n";


    $string = str_replace("|PersonList|", $personList, $string);
    $string = LanguageSupport::HTMLEvalLanguage($string);

    echo $string;

 ?>
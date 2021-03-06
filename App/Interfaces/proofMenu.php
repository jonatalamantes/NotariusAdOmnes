<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ProofManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('proofMenu.php');

    //Get File contest from template
    $string = file_get_contents("template/ProofMenu.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Validate the URL
    $numberPage    = intval($_GET["page"]);
    $sortType      = $_GET["sort"];
    $simpleKeyword = $_GET["keyword"];
    $kid           = $_GET["kid"];

    if ($sortType == NULL || $sortType == '')
    {
        $sortType = 'id';
    }

    if ($numberPage === NULL || $numberPage < 0) //Invalid Page
    {
        echo "<script src='../JS/functions.js'></script><script>nextPage('set', '0')</script>";
    }

    //Getting all registries
    if ($simpleKeyword !== NULL)
    {
        $proofRegistries = ProofManager::simpleSearchProof($simpleKeyword, $sortType, $numberPage);
    }
    else if ($kid !== NULL)
    {
        $proofSearch = new ProofTalks();

        $knamec        = $_GET["knamec"];
        $klastname1c   = $_GET["klastname1c"];
        $klastname2c   = $_GET["klastname2c"];
        $knamef        = $_GET["knamef"];
        $klastname1f   = $_GET["klastname1f"];
        $klastname2f   = $_GET["klastname2f"];
        $knamem        = $_GET["knamem"];
        $klastname1m   = $_GET["klastname1m"];
        $klastname2m   = $_GET["klastname2m"];
        $kchurch       = $_GET["kchurch"];
        $ktype         = $_GET["ktype"];

        $posibleNames[0] = PersonManager::searchPersonsByNames($knamec, $klastname1c, $klastname2c, false);
        $posibleNames[1] = PersonManager::searchPersonsByNames($knamef, $klastname1f, $klastname2f, false);
        $posibleNames[2] = PersonManager::searchPersonsByNames($knamem, $klastname1m, $klastname2m, false);

        $proofSearch->setIdOwner($posibleNames);

        $posibleChurch = ChurchManager::simpleSearchChurch($kchurch, 'id', -1);
        $proofSearch->setIdChurch($posibleChurch);

        $proofSearch->setType($ktype);

        $proofRegistries = ProofManager::advancedSearchProof($proofSearch, 'AND', $sortType, $numberPage);
    }
    else
    {
        $proofRegistries = ProofManager::getAllProofs($sortType, $numberPage);
    }

    //Get the total of registries
    $totalRegistries    = DatabaseManager::getAffectedRows();
    $affectedRegistries = DatabaseManager::registriesAffectedLastQuery();

    $lastPage = floor($affectedRegistries/10);

    if ($affectedRegistries%10 === 0)
    {
        $lastPage = floor($affectedRegistries/10)-1;
    }

    if ($totalRegistries === 0 && $numberPage !== 0)
    {
        echo "<script src='../JS/functions.js'></script><script>nextPage('set', '0')</script>";
    }

    //Create contest for button next and prev
    $nextButtonString = '<button type="button" 
                                 class="btn btn-warning"
                                 onclick="nextPage(\'true\')">
                        ^Next^</button>';

    $prevButtonString = '<button type="button" 
                                 class="btn btn-warning"
                                 onclick="nextPage(\'false\')">
                        ^Previus^</button>';

    $beggButtonString = '<button type="button" 
                                 class="btn btn-primary"
                                 onclick="nextPage(\'set\', \'0\')">
                        ^Begin^</button>';

    $lastButtonString = '<button type="button" 
                                 class="btn btn-primary"
                                 onclick="nextPage(\'set\', \''. $lastPage .'\')">
                        ^Last^</button>';

    //Create a table of registries
    $table = "<h4 style='text-align:center'>^No Contest Found^</h4>";

    if ($proofRegistries !== NULL && $totalRegistries != 0)
    {
        $table = '<table class="col-md-12 table-condensed table-bordered cf menuTable" id="table1">';

        $header = '<thead class="cf">
                    <tr>
                        <th data-title="" colspan="5" class="center"><strong>^Proof Table^</strong></th>
                        <th data-title="Sort" style="text-align: center" colspan="2" class="center">
                            ^Sort By^ 
                            <select class="form-control" id="sortType" onchange="loadSort(\'proofMenu.php\')">
                                <option ' . ($sortType=='id' ? 'selected' : '') . '>^Latest^</option>
                                <option ' . ($sortType=='nameChild' ? 'selected' : '') . '>^Lastname Child^</option>
                                <option ' . ($sortType=='nameChurch' ? 'selected' : '') . '>^Name Church^</option>
                            </select>
                        </th>
                    </tr>
                    <tr style="text-align: center;">
                        <th style="text-align: center;">^Fullname Child^</th>
                        <th style="text-align: center;">^Fullname Father^</th>
                        <th style="text-align: center;">^Fullname Mother^</th>
                        <th style="text-align: center;">^Name Church^</th>
                        <th style="text-align: center;">^Type^</th>
                        <th style="text-align: center;">^Options^</th>
                    </tr>
                   </thead>';

        $table = $table . $header;

        $table = $table . '<tbody>';
        
        $i = 0;
        foreach ($proofRegistries as $singleProof) 
        {
            if ($i === 10) 
            {
                continue;
            }

            $child = PersonManager::getSinglePerson('id', $singleProof->getIdOwner());
            $nameChild = $child->getFullName();

            $mother = PersonManager::getSinglePerson('id', $child->getIdMother());
            $nameMother = "";

            if ($mother != NULL)
            {
                $nameMother = $mother->getFullName();
            }

            $father = PersonManager::getSinglePerson('id', $child->getIdFather());
            $nameFather = "";

            if ($father != NULL)
            {
                $nameFather = $father->getFullName();
            }

            $church = ChurchManager::getSingleChurch('id', $singleProof->getIdChurch());

            if ($_SESSION["user_type"] == 'A' || $singleProof->getIdChurch() == $_SESSION["user_church"])
            {
                $options = '<td data-title="^Options^" class="center-btn" style="text-align: center">
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'proofLook.php?id=' . $singleProof->getID() . '\')">
                                    <img src="../icons/eye.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'proofChange.php?id=' . $singleProof->getID() . '\')">
                                    <img src="../icons/refresh.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="deleteObject(\'proof\', \'' . $singleProof->getID() . '\')">
                                    <img src="../icons/delete.png" class="img-inside" height="30px">
                                </button>
                            </td>';
            }
            else
            {
                $options = '<td data-title="^Options^" class="center-btn" style="text-align: center">
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'proofLook.php?id=' . $singleProof->getID() . '\')">
                                    <img src="../icons/eye.png" class="img-inside" height="30px">
                                </button>
                            </td>';
            }

            $typeString = "";

            if ($singleProof->getType() === 'B')
            {
                $typeString = "^Baptism^";
            }
            else if ($singleProof->getType() === 'C')
            {
                $typeString = "^Confirmation^";
            }
            else if ($singleProof->getType() === 'E')
            {
                $typeString = "^Communion^";
            }
            else if ($singleProof->getType() === 'X')
            {
                $typeString = "^XV^";
            }

            $table = $table . '<tr>';
            $table = $table . '<td data-title="^Fullname Child^">'   . $nameChild         . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Fullname Father^">'  . $nameFather        . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Fullname Mother^">'  . $nameMother        . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Name Church^">'      . $church->getName() . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Name Church^">'      . $typeString        . '</td>' . "\n\t\t\t\t\t";
            $table = $table . $options;
            $table = $table . '</tr>';

            $i++;
        }

        //End the table
        $table = $table . '</tbody></table>';
    }

    //Display the table
    $string = str_replace("|tableContest|", $table, $string);

    if ($totalRegistries === 11)
    {
        //put the next button
        $string = str_replace("|buttonNext|", $nextButtonString, $string);
    }
    else
    {
        //delete the next button
        $string = str_replace("|buttonNext|", "\n", $string);
    }

    if ($numberPage === 0)
    {
        //delete previus button
        $string = str_replace("|buttonPrev|", "\n", $string);

        //delete first button
        $string = str_replace("|buttonFirst|", "\n", $string);
    }
    else
    {
        //put the previus button
        $string = str_replace("|buttonPrev|", $prevButtonString, $string);

        //put the first button
        $string = str_replace("|buttonFirst|", $beggButtonString, $string);
    }

    if ($numberPage < $lastPage)
    {
        //put the next button
        $string = str_replace("|buttonLast|", $lastButtonString, $string);
    }
    else
    {
        $string = str_replace("|buttonLast|", "\n", $string);
    }

    $string = LanguageSupport::HTMLEvalLanguage($string);

    //Display the page
    echo $string;
 ?>
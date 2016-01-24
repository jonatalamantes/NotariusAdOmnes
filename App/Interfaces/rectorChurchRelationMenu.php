<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('churchMenu.php');

    //Get File contest from template
    $string = file_get_contents("template/RectorChurchRelationMenu.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Validate the URL
    $numberPage    = intval($_GET["page"]);
    $sortType      = $_GET["sort"];
    $idRector      = $_GET["id"];
    $rector        = RectorManager::getSingleRector('id', $idRector);

    if ($sortType == NULL || $sortType == '')
    {
        $sortType = 'id';
    }

    if ($numberPage === NULL || $numberPage < 0 || $idRector === "" || $rector === NULL) //Invalid Page
    {
        echo "<script src='../JS/functions.js'></script><script>href('churchMenu.php')</script>";
    }

    //Getting all registries
    $churchRegistries = RectorManager::getAllFormerChurchs($idRector, $sortType, $numberPage);

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
        echo "<script src='../JS/functions.js'></script><script>href('churchrMenu.php')</script>";
    }

    $person = $rector->getIdPerson();
    $person = PersonManager::getSinglePerson('id', $person);

    //Display the name of the church
    $string = str_replace("|Rector|", "«" . $person->getNames()     . " " .
                                            $person->getLastname1() . " " .
                                            $person->getLastname2() . "»", $string);    

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

    if ($churchRegistries !== NULL && $totalRegistries != 0)
    {
        $table = '<table class="col-md-12 table-condensed table-bordered cf menuTable" id="table1">';

        $header = '<thead class="cf">
                    <tr>
                        <th data-title="" colspan="6" class="center"><strong>^Church Table^</strong></td>
                        <th data-title="Sort" style="text-align: center" colspan="2" class="center">
                            ^Sort By^ 
                            <select class="form-control" id="sortType" onchange="loadSort(\'rectorChurchRelationMenu.php\', \'' . $idRector . '\')">
                                <option ' . ($sortType=='id'      ? 'selected' : '') . '>^Latest^</option>
                                <option ' . ($sortType=='name'    ? 'selected' : '') . '>^Name^</option>
                                <option ' . ($sortType=='address' ? 'selected' : '') . '>^Address^</option>
                            </select>
                        </th>
                    </tr>
                    <tr style="text-align: center;">
                        <th style="text-align: center;">^Name^</th>
                        <th style="text-align: center;">^Address^</th>
                        <th style="text-align: center;">^Colony^</th>
                        <th style="text-align: center;">^Vicar^</th>
                        <th style="text-align: center;">^Dean^</th>
                        <th style="text-align: center;">^City^</th>
                        <th style="text-align: center;">^Options^</th>
                    </tr>
                   </thead>';

        $table = $table . $header;

        $table = $table . '<tbody>';

        $i = 0;
        foreach ($churchRegistries as $singleChurch) 
        {
            if ($i === 10)
            {
                continue;
            }

            $vicar = ChurchManager::getSingleVicar('id', $singleChurch->getIdVicar());
            $nameVicar = $vicar->getName();

            $dean = ChurchManager::getSingleDean('id', $singleChurch->getIdDean());
            $nameDean = $dean->getName();

            $city = CityManager::getSingleCity('id', $singleChurch->getIdCity());
            $nameCity = $city->getName();

            if ($_SESSION["user_type"] == 'A')
            {
                $options = '<td data-title="^Options^" class="center-btn" style="text-align: center">
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'churchLook.php?id=' . $singleChurch->getID() . '\')">
                                    <img src="../icons/eye.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'churchChange.php?id=' . $singleChurch->getID() . '\')">
                                    <img src="../icons/refresh.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="deleteObject(\'church\', \'' . $singleChurch->getID() . '\')">
                                    <img src="../icons/delete.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'churchRectorRelationMenu.php?id=' . $singleChurch->getID() . '\')">
                                    <img src="../icons/rector.png" class="img-inside" height="30px">
                                </button>
                            </td>';
            }
            else
            {
                $options = '<td data-title="^Options^" class="center-btn" style="text-align: center">
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'churchLook.php?id=' . $singleChurch->getID() . '\')">
                                    <img src="../icons/eye.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'churchRectorRelationMenu.php?id=' . $singleChurch->getID() . '\')">
                                    <img src="../icons/rector.png" class="img-inside" height="30px">
                                </button>
                            </td>';                
            }

            $table = $table . '<tr>';
            $table = $table . '<td data-title="^Name^">'   . $singleChurch->getName()    . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Address^">'. $singleChurch->getAddress() . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Colony^">' . $singleChurch->getColony()  . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Vicar^">'  . $nameVicar                  . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Dean^">'   . $nameDean                   . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^City^">'   . $nameCity                   . '</td>' . "\n\t\t\t\t\t";
            $table = $table . $options;
            $table = $table . '</tr>';
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

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    $string = SessionManager::permisionTag($string);
    
    echo $string;
 ?>
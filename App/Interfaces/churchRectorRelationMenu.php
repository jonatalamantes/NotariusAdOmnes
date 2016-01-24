<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('rectorMenu.php');

    //Get File contest from template
    $string = file_get_contents("template/ChurchRectorRelationMenu.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Validate the URL
    $numberPage    = intval($_GET["page"]);
    $sortType      = $_GET["sort"];
    $idChurch      = $_GET["id"];
    $church        = ChurchManager::getSingleChurch('id', $idChurch);

    if ($sortType == NULL || $sortType == '')
    {
        $sortType = 'id';
    }

    if ($numberPage === NULL || $numberPage < 0 || $idChurch === "" || $church === NULL) //Invalid Page
    {
        echo "<script src='../JS/functions.js'></script><script>href('rectorMenu.php')</script>";
    }

    //Display the name of the church
    $string = str_replace("|Church|", "«" . $church->getName() . "»", $string);    

    //Getting all registries
    $rectorRegistries = RectorManager::getAllFormerRectors($idChurch, $sortType, $numberPage);

    //Get the total of registries
    $totalRegistries    = DatabaseManager::getAffectedRows();
    $affectedRegistries = DatabaseManager::registriesAffectedLastQuery();

    if ($totalRegistries === 0 && $numberPage !== 0)
    {
        echo "<script src='../JS/functions.js'></script><script>href('rectorMenu.php')</script>";
    }

    $lastPage = floor($affectedRegistries/10);

    if ($affectedRegistries%10 === 0)
    {
        $lastPage = floor($affectedRegistries/10)-1;
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
    $table = "<h4 style='text-align:center'>^No Rectors in this Church^</h4>";

    if ($rectorRegistries !== NULL && $totalRegistries != 0)
    {
        $table = '<table class="col-md-12 table-condensed table-bordered cf menuTable" id="table1">';

        $header = '<thead class="cf">
                    <tr>
                        <th data-title="" colspan="5" class="center"><strong>^Rector Table^</strong></td>
                        <th data-titleSort="" style="text-align: center" colspan="2" class="center">
                            ^Sort By^ 
                            <select class="form-control" id="sortType" onchange="loadSort(\'churchRectorRelationMenu.php\', \'' . $idChurch . '\')">
                                <option ' . ($sortType=='id'      ? 'selected' : '') . '>^Latest^</option>
                                <option ' . ($sortType=='name'    ? 'selected' : '') . '>^Lastname Rector^</option>
                                <option ' . ($sortType=='church'  ? 'selected' : '') . '>^Actual Church^</option>
                            </select>
                        </th>
                    </tr>
                    <tr style="text-align: center;">
                        <th style="text-align: center;">^Name^</th>
                        <th style="text-align: center;">^Type^</th>
                        <th style="text-align: center;">^Status^</th>
                        <th style="text-align: center;">^Position^</th>
                        <th style="text-align: center;">^Actual Church^</th>
                        <th style="text-align: center;">^Options^</th>
                    </tr>
                   </thead>';

        $table = $table . $header;

        $table = $table . '<tbody>';

        $i = 0;
        foreach ($rectorRegistries as $singleRector) 
        {
            if ($i === 10)
            {
                continue;
            }

            $person  = PersonManager::getSinglePerson('id', $singleRector->getIdPerson());
            $name    = $person->getFullName();

            $church = ChurchManager::getSingleChurch('id', $singleRector->getIdActualChurch());
            $status = "Active";

            if ($singleRector->getStatus() !== 'A')
            {
                $status = "Inactive";
            }

            if ($_SESSION["user_type"] == 'A')
            {
                $options = '<td data-title="^Options^" class="center-btn" style="text-align: center">
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'rectorLook.php?id=' . $singleRector->getID() . '\')">
                                    <img src="../icons/eye.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'rectorChange.php?id=' . $singleRector->getID() . '\')">
                                    <img src="../icons/refresh.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="deleteObject(\'rector\', \'' . $singleRector->getID() . '\')">
                                    <img src="../icons/delete.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'rectorChurchRelationMenu.php?id=' . $singleRector->getID() . '\')">
                                    <img src="../icons/church.png" class="img-inside" height="30px">
                                </button>
                            </td>';
            }
            else
            {
                $options = '<td data-title="^Options^" class="center-btn" style="text-align: center">
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'rectorLook.php?id=' . $singleRector->getID() . '\')">
                                    <img src="../icons/eye.png" class="img-inside" height="30px">
                                </button>
                                <button type="button" class="btn btn-success btn-inside" onclick="href(\'rectorChurchRelationMenu.php?id=' . $singleRector->getID() . '\')">
                                    <img src="../icons/church.png" class="img-inside" height="30px">
                                </button>
                            </td>';
            }

            $table = $table . '<tr>';
            $table = $table . '<td data-title="^Name^">'          . $name                        . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Type^">'          . $singleRector->getType()     . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Status^">'        . $status                      . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Position^">'      . $singleRector->getPosition() . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Actual Church^">' . $church->getName()           . '</td>' . "\n\t\t\t\t\t";
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
    
    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    $string = SessionManager::permisionTag($string);
    echo $string;
 ?>
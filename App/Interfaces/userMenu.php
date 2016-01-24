<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('userMenu.php');

    //Get File contest from template
    $string = file_get_contents("template/UserMenu.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Validate the URL
    $numberPage    = intval($_GET["page"]);
    $sortType      = $_GET["sort"];
    $simpleKeyword = $_GET["keyword"];
    $kid           = $_GET["kid"];

    if ($sortType == NULL || $sortType == '')
    {
        $sortType = 'id DESC';
    }

    if ($numberPage === NULL || $numberPage < 0) //Invalid Page
    {
        echo "<script src='../JS/functions.js'></script><script>nextPage('set', '0')</script>";
    }

    //Getting all registries
    if ($simpleKeyword !== NULL)
    {
        $userRegistries = SessionManager::simpleSearchUser($simpleKeyword, $sortType, $numberPage);
    }
    else if ($kid !== NULL)
    {
        $userSearch = new User();

        $kusername     = $_GET["kusername"];
        $ktype         = $_GET["ktype"];
        $konlineCheck  = $_GET["konlineCheck"];
        $kchurch       = $_GET["kchurch"];

        $userSearch->setId($kid);
        $userSearch->setType($ktype);
        $userSearch->setOffline($konlineCheck);
        $userSearch->setUsername($kusername);

        $posibleChurch = ChurchManager::simpleSearchChurch($kchurch, 'id', -1);
        $userSearch->setIdChurch($posibleChurch);

        $userRegistries = SessionManager::advancedSearchUser($userSearch, 'AND', $sortType, $numberPage);
    }
    else
    {
        $userRegistries = SessionManager::getAllUsers($sortType, $numberPage);
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

    if ($userRegistries !== NULL && $totalRegistries != 0)
    {
        $table = '<table class="col-md-12 table-condensed table-bordered cf menuTable" id="table1">';

        $header = '<thead class="cf">
                    <tr>
                        <th data-title="" colspan="3" class="center"><strong>^User Table^</strong></th>
                        <th data-title="Sort" style="text-align: center" class="center" colspan="2">
                            ^Sort By^ 
                            <select class="form-control" id="sortType" onchange="loadSort(\'userMenu.php\', \'\')">
                                <option ' . ($sortType=='id' ? 'selected' : '') . '>^Latest^</option>
                                <option ' . ($sortType=='username' ? 'selected' : '') . '>^Username^</option>
                                <option ' . ($sortType=='nameChurch' ? 'selected' : '') . '>^Name Church^</option>
                            </select>
                        </th>
                    </tr>
                    <tr style="text-align: center;">
                        <th style="text-align: center;">^Online^</th>
                        <th style="text-align: center;">^Username^</th>
                        <th style="text-align: center;">^Name Church^</th>
                        <th style="text-align: center;">^Type^</th>
                        <th style="text-align: center;">^Options^</th>
                    </tr>
                   </thead>';

        $table = $table . $header;

        $table = $table . '<tbody>';

        $i = 0;
        foreach ($userRegistries as $singleUser) 
        {
            if ($i === 10)
            {
                continue;
            }

            $username = $singleUser->getUsername();
            $type     = $singleUser->getType();
            $offline  = $singleUser->getOffline();

            $church = ChurchManager::getSingleChurch('id', $singleUser->getIdChurch());

            $options = '<td data-title="^Options^" class="center-btn" style="text-align: center">
                            <button type="button" class="btn btn-success btn-inside" onclick="href(\'userMessage.php?id=' . $singleUser->getID() . '\')">
                                <img src="../icons/message.png" class="img-inside" height="30px">
                            </button>
                        </td>';

            if ($_SESSION["user_id"] == $singleUser->getId())
            {
                $options = '';
            }

            if ($offline == '1')
            {
                $offline = "^Offline^";
            }
            else
            {
                $offline = "^Online^";   
            }

            if ($type == 'A')
            {
                $type = '^Administrator^';
            }
            else
            {
                $type = '^Normal^';
            }

            $table = $table . '<tr>';
            $table = $table . '<td data-title="^Online^">'   . $offline              . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Username^">'   . $username              . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Name Church^">'      . $church->getName()      . '</td>' . "\n\t\t\t\t\t";
            $table = $table . '<td data-title="^Type^">'   . $type              . '</td>' . "\n\t\t\t\t\t";
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
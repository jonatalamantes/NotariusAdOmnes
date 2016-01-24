<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('config.php');

    //Get File Contest
    $string = file_get_contents("template/Config.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    //Get the alert to keep
    $alert  = "";

    if (isset($_GET) && $_GET["success"] === 'true')
    {
        $alert = '  <div class="alert alert-success" role="alert" style="text-align: center;">
                        <h3>^Successful Change^</h3>
                    </div>';
    }

    //Set the language of the select
    $actualLanguage = LanguageSupport::getActualLanguage();

    if ($actualLanguage === 'en')
    {
        $string = str_replace("|isEnglish|", 'selected', $string);
    }
    else if ($actualLanguage === 'en')
    {
        $string = str_replace("|isEnglish|", 'selected', $string);
    }

    $string = str_replace("|Alert|", $alert, $string);

    //Get the data value
    $user = SessionManager::getCurrentUser();
    $paperConfig = SessionManager::getSinglePaperConfig('id', $user->getIdPaperConfig());

    $cbcx = $paperConfig->getCopyBaptismCertX();
    $cbcy = $paperConfig->getCopyBaptismCertY();
    $bcx  = $paperConfig->getBaptismCertX();
    $bcy  = $paperConfig->getBaptismCertY();

    $cecx = $paperConfig->getCopyCommunionCertX();
    $cecy = $paperConfig->getCopyCommunionCertY();
    $ecx  = $paperConfig->getCommunionCertX();
    $ecy  = $paperConfig->getCommunionCertY();

    $cccx = $paperConfig->getCopyConfirmationCertX();
    $cccy = $paperConfig->getCopyConfirmationCertY();
    $ccx  = $paperConfig->getConfirmationCertX();
    $ccy  = $paperConfig->getConfirmationCertY();

    $mcx  = $paperConfig->getMarriageCertX();
    $mcy  = $paperConfig->getMarriageCertY();
    $mbx  = $paperConfig->getMarriageConstancyX();
    $mby  = $paperConfig->getMarriageConstancyY();
    $mnx  = $paperConfig->getMarriageNoticeX();
    $mny  = $paperConfig->getMarriageNoticeY();
    $mex  = $paperConfig->getMarriageExhortX();
    $mey  = $paperConfig->getMarriageExhortY();
    $mtx  = $paperConfig->getMarriageTraslationX();
    $mty  = $paperConfig->getMarriageTraslationY();

    //Create a Button State
    $saveButton = '<button type="button" class="btn btn-success" onclick=\'validateData("config.php")\'>
                      <img src="../icons/save.png" width="50px"><br>
                      <strong>^Save^</strong>
                   </button>';

    $cancelButton = '<button type="button" class="btn btn-success" onclick=\'href("main.php")\'>
                        <img src="../icons/delete.png" width="50px"><br>
                        <strong>^Cancel^</strong>
                    </button>';

    $returnButton = '';

    $string = str_replace("|SaveButton|"  , $saveButton  , $string);
    $string = str_replace("|CancelButton|", $cancelButton, $string);
    $string = str_replace("|ReturnButton|", $returnButton, $string);

    //Script
    $script = "<script>
                $('#cbcx').val('$cbcx');
                $('#cbcy').val('$cbcy');
                $('#bcx').val('$bcx');
                $('#bcy').val('$bcy');

                $('#cecx').val('$cecx');
                $('#cecy').val('$cecy');
                $('#ecx').val('$ecx');
                $('#ecy').val('$ecy');

                $('#cccx').val('$cccx');
                $('#cccy').val('$cccy');
                $('#ccx').val('$ccx');
                $('#ccy').val('$ccy');
                
                $('#mcx').val('$mcx');
                $('#mcy').val('$mcy');
                $('#mbx').val('$mbx');
                $('#mby').val('$mby');
                $('#mnx').val('$mnx');
                $('#mny').val('$mny');
                $('#mex').val('$mex');
                $('#mey').val('$mey');
                $('#mtx').val('$mtx');
                $('#mty').val('$mty');

               </script>";

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;
    echo $script;
 ?>
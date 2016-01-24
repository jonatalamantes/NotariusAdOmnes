<?php 

    require_once(__DIR__."/../../../Backend/Certs/MarriageNotice.php");

    SessionManager::validateUserInPage('marriageLook.php');

    if (isset($_GET)     && $_GET["idMarriage"]   !== NULL && 
        isset($_SESSION) && $_SESSION["user_id"] !== NULL)
    {
        $user = SessionManager::getCurrentUser();

        $pdf = new MarriageNotice($user->getId(), $_GET["idMarriage"], $_GET["full"]);
        $pdf->AliasNbPages();

        $pdf->setType('no-reverse');
        $pdf->setOwner('boyfriend');
        $pdf->AddPage();
        $pdf->displayData();
        
        $pdf->setType('reverse');
        $pdf->AddPage();
        $pdf->displayData();
        
        $pdf->setType('no-reverse');
        $pdf->setOwner('girlfriend');
        $pdf->AddPage();
        $pdf->displayData();

        $pdf->setType('reverse');
        $pdf->AddPage();
        $pdf->displayData();

        $pdf->setType('no-reverse');        
        $pdf->Output();
    }
    else
    {
        echo "<script>
                url = String(window.location);
                url = url.substr(0, url.indexOf('cert'));
                window.location.href = url + 'main.php';
              </script>";
    }

 ?>
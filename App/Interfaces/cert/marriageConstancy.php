<?php 

    require_once(__DIR__."/../../../Backend/Certs/MarriageConstancy.php");

    SessionManager::validateUserInPage('marriageLook.php');

    if (isset($_GET)     && $_GET["idMarriage"]   !== NULL && 
        isset($_SESSION) && $_SESSION["user_id"] !== NULL)
    {
        $user = SessionManager::getCurrentUser();

        $pdf = new MarriageConstancy($user->getId(), $_GET["idMarriage"], $_GET["full"]);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->displayData();
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
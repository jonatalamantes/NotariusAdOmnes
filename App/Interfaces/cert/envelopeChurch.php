<?php 

    require_once(__DIR__."/../../../Backend/Certs/EnvelopeChurch.php");

    SessionManager::validateUserInPage('churchLook.php');

    if (isset($_GET)     && $_GET["idChurch"]   !== NULL && 
        isset($_SESSION) && $_SESSION["user_id"] !== NULL)
    {
        $user = SessionManager::getCurrentUser();

        $pdf = new EnvelopeChurch($user->getId(), $_GET["idChurch"]);
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
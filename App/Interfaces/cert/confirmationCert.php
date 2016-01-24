<?php 

    require_once(__DIR__."/../../../Backend/Certs/ConfirmationCertificate.php");

    SessionManager::validateUserInPage('confirmationLook.php');

    if (isset($_GET)     && $_GET["idConfirmation"] !== NULL && 
        isset($_SESSION) && $_SESSION["user_id"] !== NULL)
    {

        $user = SessionManager::getCurrentUser();

        $pdf = new ConfirmationCertificate($user->getId(), $_GET["idConfirmation"], $_GET["full"]);
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
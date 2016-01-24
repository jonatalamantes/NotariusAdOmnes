<?php 

    require_once(__DIR__."/../../../Backend/Certs/CommunionCertificate.php");

    SessionManager::validateUserInPage('communionLook.php');

    if (isset($_GET)     && $_GET["idCommunion"] !== NULL && 
        isset($_SESSION) && $_SESSION["user_id"] !== NULL)
    {

        $user = SessionManager::getCurrentUser();

        $pdf = new CommunionCertificate($user->getId(), $_GET["idCommunion"], $_GET["full"]);
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
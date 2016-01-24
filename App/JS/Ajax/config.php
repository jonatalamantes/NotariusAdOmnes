<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");

    if (isset($_POST) && $_POST["language"] !== NULL)
    {
        $user = SessionManager::getCurrentUser();

        if ($_POST["language"] == 'Spanish' || $_POST["language"] == 'Español')
        {
            $user->setLanguage('es');
        }
        else if ($_POST["language"] == 'English' || $_POST["language"] == 'Inglés')
        {
            $user->setLanguage('en');
        }

        $paperConfig = SessionManager::getSinglePaperConfig('id', $user->getIdPaperConfig());

        $paperConfig->setCopyBaptismCertX($_POST["cbcx"]);
        $paperConfig->setCopyBaptismCertY($_POST["cbcy"]);
        $paperConfig->setBaptismCertX($_POST["bcx"]);
        $paperConfig->setBaptismCertY($_POST["bcy"]);

        $paperConfig->setCopyCommunionCertX($_POST["cecx"]);
        $paperConfig->setCopyCommunionCertY($_POST["cecy"]);
        $paperConfig->setCommunionCertX($_POST["ecx"]);
        $paperConfig->setCommunionCertY($_POST["ecy"]);

        $paperConfig->setCopyConfirmationCertX($_POST["cccx"]);
        $paperConfig->setCopyConfirmationCertY($_POST["cccy"]);
        $paperConfig->setConfirmationCertX($_POST["ccx"]);
        $paperConfig->setConfirmationCertY($_POST["ccy"]);

        $paperConfig->setMarriageCertX($_POST["mcx"]);
        $paperConfig->setMarriageCertY($_POST["mcy"]);
        $paperConfig->setMarriageConstancyX($_POST["mbx"]);
        $paperConfig->setMarriageConstancyY($_POST["mby"]);
        $paperConfig->setMarriageNoticeX($_POST["mnx"]);
        $paperConfig->setMarriageNoticeY($_POST["mny"]);
        $paperConfig->setMarriageExhortX($_POST["mex"]);
        $paperConfig->setMarriageExhortY($_POST["mey"]);
        $paperConfig->setMarriageTraslationX($_POST["mtx"]);
        $paperConfig->setMarriageTraslationY($_POST["mty"]);

        SessionManager::updateUser($user);
        SessionManager::updatePaperConfig($paperConfig);

        echo "OK";
    }
    else
    {
        echo "KO";
    }


 ?>
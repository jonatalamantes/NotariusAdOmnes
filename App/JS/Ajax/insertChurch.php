<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/RectorManager.php");
    require_once(__DIR__."/../../../Backend/ChurchManager.php");

    if (!isset($_GET) || $_GET["nameChuch"] === NULL)
    {
        echo "KO";
        die;
    }

    if ($_GET["status"] === 'insert' && 
        ChurchManager::getSingleChurch('name', $_GET["nameChuch"]) !== NULL)
    {
        echo "KO";
    }
    else
    {
        $status = $_GET["status"];
        $church = NEW Church();

        $church->setId(0);
        $church->setName($_GET["nameChuch"]);
        $church->setType($_GET["typeChurch"]);
        $church->setCode($_GET["codeChurch"]);
        $church->setAddress($_GET["addressChurch"]);
        $church->setColony($_GET["colonyChurch"]);
        $church->setPostalCode($_GET["postalCodeChurch"]);
        $church->setPhoneNumber($_GET["phoneNumberChurch"]);
        $church->setIdVicar(ChurchManager::getSingleVicar('name', $_GET["vicar"])->getId());
        $church->setIdDean(ChurchManager::getSingleDean('name', $_GET["dean"])->getId());
        $church->setIdCity(CityManager::getSingleCity('name', $_GET["city"])->getId());
        $niches = $_GET["niche"];

        if ($niches == 'true')
        {
            $niche = new Niche();

            $niche->setMaxCol($_GET["maxCol"]);
            $niche->setMaxRow($_GET["maxRow"]);
            $niche->setSize($_GET["size"]);

            $nicheT = (ChurchManager::getSingleNiche('maxCol', $niche->getMaxCol(),
                                                     'maxRow', $niche->getMaxRow(),
                                                     'size',   $niche->getSize()));

            if ($nicheT === NULL) //No niche
            {
                ChurchManager::addNiche($niche);

                $nicheT = ChurchManager::getSingleNiche('maxCol', $niche->getMaxCol(),
                                                        'maxRow', $niche->getMaxRow(),
                                                        'size',   $niche->getSize());            

                $church->setIdNiche($nicheT->getId());
            }   
            else
            {
                $church->setIdNiche($nicheT->getId());
            }
        }
        else
        {
            $church->setIdNiche('NULL');
        }

        if ($status === 'update')
        {
            $church->setId($_GET["id"]);

            if (ChurchManager::updateChurch($church))
            {
                echo "OK";
            }
            else
            {
                echo "KO";
            }
        }
        else if ($status === 'insert')
        {
            if (ChurchManager::addChurch($church))
            {
                echo "OK";
            }
            else
            {
                echo "KO";
            }
        }
    }

 ?>
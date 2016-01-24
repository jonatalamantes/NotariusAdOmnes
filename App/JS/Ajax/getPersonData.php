<?php 

    require_once(__DIR__."/../../../Backend/SessionManager.php");
    require_once(__DIR__."/../../../Backend/PersonManager.php");
    require_once(__DIR__."/../../../Backend/BaptismManager.php");

    if (!isset($_GET) || $_GET["id"] === NULL)
    {
        echo "KO";
        die;
    }

    $stringResponse = "";

    $child  = PersonManager::getSinglePerson('id', $_GET["id"]);
    $father = PersonManager::getSinglePerson('id', $child->getIdFather());
    $mother = PersonManager::getSinglePerson('id', $child->getIdMother());

    $gpp = NULL;
    $gmp = NULL;
    $gpm = NULL;
    $gmm = NULL;

    if ($father !== NULL)
    {
        $gpp    = PersonManager::getSinglePerson('id', $father->getIdFather());
        $gmp    = PersonManager::getSinglePerson('id', $father->getIdMother());
    }

    if ($mother !== NULL)
    {
        $gpm    = PersonManager::getSinglePerson('id', $mother->getIdFather());
        $gmm    = PersonManager::getSinglePerson('id', $mother->getIdMother());
    }

    //Abouth The Child
    $stringResponse = $stringResponse .
                      "namec=" . $child->getNames().
                      "&lastname1c=" . $child->getLastname1() .
                      "&lastname2c=" . $child->getLastname2();

    if ($father === NULL)
    {
        $stringResponse = $stringResponse .
                          "&namef=&lastname1f=&lastname2f=";
    }
    else
    {
        $stringResponse = $stringResponse .
                          "&namef="      . $father->getNames() .
                          "&lastname1f=" . $father->getLastname1() .
                          "&lastname2f=" . $father->getLastname2();
    }

    if ($mother === NULL)
    {
        $stringResponse = $stringResponse .
                          "&namem=&lastname1m=&lastname2m=";
    }
    else
    {
        $stringResponse = $stringResponse .
                          "&namem="      . $mother->getNames() .
                          "&lastname1m=" . $mother->getLastname1() .
                          "&lastname2m=" . $mother->getLastname2();
    }

    if ($gpp === NULL)
    {
        $stringResponse = $stringResponse .
                          "&namegpp=&lastname1gpp=&lastname2gpp=";
    }
    else
    {
        $stringResponse = $stringResponse .
                          "&namegpp="      . $gpp->getNames() .
                          "&lastname1gpp=" . $gpp->getLastname1() .
                          "&lastname2gpp=" . $gpp->getLastname2();
    }

    if ($gmp === NULL)
    {
        $stringResponse = $stringResponse .
                          "&namegmp=&lastname1gmp=&lastname2gmp=";
    }
    else
    {
        $stringResponse = $stringResponse .
                          "&namegmp="      . $gmp->getNames() .
                          "&lastname1gmp=" . $gmp->getLastname1() .
                          "&lastname2gmp=" . $gmp->getLastname2();
    }

    if ($gpm === NULL)
    {
        $stringResponse = $stringResponse .
                          "&namegpm=&lastname1gpm=&lastname2gpm=";
    }
    else
    {
        $stringResponse = $stringResponse .
                          "&namegpm="      . $gpm->getNames() .
                          "&lastname1gpm=" . $gpm->getLastname1() .
                          "&lastname2gpm=" . $gpm->getLastname2();
    }

    if ($gmm === NULL)
    {
        $stringResponse = $stringResponse .
                          "&namegmm=&lastname1gmm=&lastname2gmm=";
    }
    else
    {
        $stringResponse = $stringResponse .
                          "&namegmm="      . $gmm->getNames() .
                          "&lastname1gmm=" . $gmm->getLastname1() .
                          "&lastname2gmm=" . $gmm->getLastname2();
    }
    
    $baptism = BaptismManager::getSingleBaptism('idOwner', $child->getId());
    
    if ($baptism !== NULL)
    {
        $baptismReg = BaptismManager::getSingleBaptismRegistry('id', $baptism->getIdBookRegistry());
        
        $stringResponse = $stringResponse .
                          "&idBap="   . $baptism->getId() .
                          "&dateBap=" . DatabaseManager::databaseDateToSingleDate($baptism->getCelebrationDate()) .
                          "&bookBap=" . $baptismReg->getBook() .
                          "&pageBap=" . $baptismReg->getPage() .
                          "&numbBap=" . $baptismReg->getNumber() . "&";
    }
    else
    {
        $stringResponse = $stringResponse .
                          "&idBap=0&dateBap=&bookBap=&pageBap=&numbBap=&";
    }
                      
    echo $stringResponse;
 ?>
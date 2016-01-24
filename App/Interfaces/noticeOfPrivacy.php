<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/CityManager.php");
    require_once(__DIR__."/../../Backend/LanguageSupport.php");

    SessionManager::validateUserInPage('NoticeOfPrivacy.php');

    //Get File Contest
    $string = file_get_contents("template/NoticeOfPrivacy.html");

    //Remplace the nav
    $string = str_replace("|NavBar|", SessionManager::getNavBar(), $string);

    $notice = "";

    if (LanguageSupport::getActualLanguage() == 'es')
    {
        $notice = "Le informamos que sus datos personales recabados a través de sus solicitudes 
                   acudiendo a alguna iglesia de la Zona Metropolitana del estado de Jalisco, 
                   son incorporadas, protegidas y tratadas en los sistemas de datos personales del 
                   Arzobispado de Guadalajara para el ejercicio de las facultades de esta 
                   institución, y sólo pueden ser proporcionados en los términos establecidos en el 
                   Artículo 69 del Código Fiscal de la Federación.
                   <br><br>
                   Si desea modificar o corregir sus datos personales, puede hacerlo a través de 
                   acudir a cualquier iglesia donde ya haya hecho algun trámite o 
                   directamente en la oficina central.
                   <br><br>
                   Lo anterior se informa en cumplimiento del Lineamiento Decimoséptimo de los 
                   Lineamientos de Protección de Datos Personales, publicados en el Diario Oficial 
                   de la Federación el 30 de septiembre de 2005.";
    }
    else
    {
        $notice = "We inform the personal data that is received through his request            
                   going to a church of the Metropolitan Zone of the State of Jalisco,        
                   are incorpored, protected and storage in the systems of the personal data by  
                   Arzobispado de Guadalajara for the execution of the faculties of this  
                   institution and only can be received in the established center in the          
                   'Artículo 69 del Código Fiscal de la Federación'.
                   <br><br>
                   if you want to change or update his personal data could done through of 
                   going to any church that you was done a request or go to the central office.
                   <br><br>
                   The Before inform the fulfillment of the 'Lineamiento Decimoséptimo' of 
                   'Lineamientos de Protección de Datos Personales', publish in the official diary   
                   of the Federation September 30th 2005.";
    }

    $string = str_replace("|NoticeOfPrivacy|", $notice, $string);

    //Display the page
    $string = LanguageSupport::HTMLEvalLanguage($string);
    echo $string;

 ?>
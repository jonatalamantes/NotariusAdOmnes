<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Marriage Traslation
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class MarriageTraslation extends FPDF
    {
        private $marriage;
        private $user;
        private $full;
        private $type;

        /**
         * Class Constructor
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser     idUser
         * @param  integer $idMarriage idMarriage
         * @param  boolean $full       full document
         */
        function __construct($idUser = 0, $idMarriage = 0, $full = false)
        {
            //Define the constructor
            parent::FPDF('P', 'mm', 'letter');

            $this->marriage = MarriageManager::getSingleMarriage('id', $idMarriage);
            $this->user    = SessionManager::getSingleUser('id', $idUser);

            $this->full = $full;
        }

        function displayData()
        {
            //Get the data necesary of create the document
            $month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            $userChurch = $this->user->getIdChurch();
            $userChurch = ChurchManager::getSingleChurch('id', $userChurch);

            $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
            $rectorUserP = $rectorUser->getPosition();
            $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

            $marriageChurchProcess = $this->marriage->getIdChurchProcess();
            $marriageChurchProcess = ChurchManager::getSingleChurch('id', $marriageChurchProcess);
            $cityChurchProcess = CityManager::getSingleCity('id', $marriageChurchProcess->getIdCity());

            $marriageChurch = $this->marriage->getIdChurchMarriage();
            $marriageChurch = ChurchManager::getSingleChurch('id', $marriageChurch);
            $cityChurchMarriage = CityManager::getSingleCity('id', $marriageChurch->getIdCity());

            $rectorMarriage = $this->marriage->getIdRector();
            $rectorMarriage = RectorManager::getSingleRector('id', $rectorMarriage);
            $rectorMarriageP = PersonManager::getSinglePerson('id', $rectorMarriage->getIdPerson());

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->marriage->getCelebrationDate());

            $boyfriend   = PersonManager::getSinglePerson('id', $this->marriage->getIdBoyfriend());
            $girlfriend  = PersonManager::getSinglePerson('id', $this->marriage->getIdGirlfriend());

            //Get the baptism of the boyfriend
            $baptismBoy   = BaptismManager::getSingleBaptism('idOwner', $boyfriend->getId());
            $baptismGirl  = BaptismManager::getSingleBaptism('idOwner', $girlfriend->getId());

            $fatherBoy = PersonManager::getSinglePerson('id', $boyfriend->getIdFather());

            if ($fatherBoy === NULL)
            {
                $fatherBoy = new Person(0, '*****************');
            }

            $motherBoy = PersonManager::getSinglePerson('id', $boyfriend->getIdMother());

            if ($motherBoy === NULL)
            {
                $motherBoy = new Person(0, '*****************');
            }

            $fatherGirl = PersonManager::getSinglePerson('id', $girlfriend->getIdFather());

            if ($fatherGirl === NULL)
            {
                $fatherGirl = new Person(0, '*****************');
            }

            $motherGirl = PersonManager::getSinglePerson('id', $girlfriend->getIdMother());

            if ($motherGirl === NULL)
            {
                $motherGirl = new Person(0, '*****************');
            }

            $godFather = PersonManager::getSinglePerson('id', $this->marriage->getIdGodFather());
            $godMother = PersonManager::getSinglePerson('id', $this->marriage->getIdGodMother());

            $witness1 = PersonManager::getSinglePerson('id', $this->marriage->getIdWitness1());
            $witness2 = PersonManager::getSinglePerson('id', $this->marriage->getIdWitness2());

            if ($godFather === NULL)
            {
                $godFather = new Person(0, "*************************");
            }

            if ($godMother === NULL)
            {
                $godMother = new Person(0, "*************************");
            }

            if ($witness1 === NULL)
            {
                $witness1 = new Person(0, "*************************");
            }

            if ($witness2 === NULL)
            {
                $witness2 = new Person(0, "*************************");
            }

            $marriageRegistry = MarriageManager::getSingleMarriageRegistry('id', $this->marriage->getIdBookRegistry());

            if ($marriageRegistry === NULL)
            {
                $marriageRegistry = new MarriageRegistry();
            }

            //Config the document 
            $this->SetFont('Arial','B', 9);
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSizeY = 5;
            $test = 0;

            if ($this->full == 'true')
            {
                $x = 0;
                $y = 0;
            
                if ($this->type == 'no-reverse')
                {
                    $this->Image(__DIR__."/../../Backend/Certs/img/marriageTraslation1.jpg", $x+9, $y+5, 203, 276);    
                }
                else
                {
                    $this->Image(__DIR__."/../../Backend/Certs/img/marriageTraslation2.jpg", $x+20, $y+18, 177, 261);
                }
            }
            else
            {
                $x = intval($paperConfig->getMarriageCertX());
                $y = intval($paperConfig->getMarriageCertY());
            }

            //Put the data of the Cert

            if ($this->type == 'no-reverse')
            {
                //Get The Book Registry
                $page = $marriageRegistry->getPage();

                if ($marriageRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }

                $stringExp = $marriageRegistry->getBook() . ", " . $page . ", " . $marriageRegistry->getNumber(); 
                $this->SetXY($x+187, $y+49-$cellSizeY);
                $this->Cell(20, $cellSizeY, $stringExp, $test, 0, 'L');

                //Get user Church Process Name 
                $this->SetXY($x+58, $y+62-$cellSizeY);
                $this->Cell(116, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurchProcess->getName()), $test, 0, 'C');

                //Get user Church Process Code 
                $this->SetXY($x+183, $y+62-$cellSizeY);
                $this->Cell(17, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurchProcess->getCode()), $test, 0, 'C');

                //Get user Church Process Address
                $this->SetXY($x+44, $y+68-$cellSizeY);
                $this->Cell(130, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurchProcess->getAddress()), $test, 0, 'C');

                //Get user Church Process City 
                $cityTemp   = CityManager::getSingleCity('id', $marriageChurchProcess->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+40, $y+74-$cellSizeY);
                $this->Cell(134, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                //Get user Church Marriage Name 
                $this->SetXY($x+77, $y+82-$cellSizeY);
                $this->Cell(97, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getName()), $test, 0, 'C');

                //Get user Church Marriage Code 
                $this->SetXY($x+183, $y+82-$cellSizeY);
                $this->Cell(17, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getCode()), $test, 0, 'C');

                //Get user Church Marriage Address
                $this->SetXY($x+44, $y+88-$cellSizeY);
                $this->Cell(130, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getAddress()), $test, 0, 'C');

                //Get user Church _Marriage City 
                $cityTemp   = CityManager::getSingleCity('id', $marriageChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+40, $y+94-$cellSizeY);
                $this->Cell(134, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                //Get the Boyfriend Names
                $this->SetXY($x+149, $y+103-$cellSizeY);
                $this->Cell(52, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getNames()), $test, 0, 'C');

                //Get the Boyfriend Names
                $this->SetXY($x+27, $y+109-$cellSizeY);
                $this->Cell(72, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getLastname1() . " " . $boyfriend->getLastname2()), $test, 0, 'C');

                //Get the Boyfriend Father
                $this->SetXY($x+117, $y+109-$cellSizeY);
                $this->Cell(84, $cellSizeY, iconv('utf-8', 'cp1252', $fatherBoy->getFullNameBeginName()), $test, 0, 'C');

                //Get the Boyfriend Mother
                $this->SetXY($x+56, $y+115-$cellSizeY);
                $this->Cell(117, $cellSizeY, iconv('utf-8', 'cp1252', $motherBoy->getFullNameBeginName()), $test, 0, 'C');

                if ($baptismBoy !== NULL)
                {
                    //Get the Boyfriend Mother
                    $baptismChurch     = $baptismBoy->getIdChurch();
                    $baptismChurch     = ChurchManager::getSingleChurch('id', $baptismChurch);
                    $cityChurchBaptism = CityManager::getSingleCity('id', $baptismChurch->getIdCity());
                    $stateTemp         = CityManager::getSingleState('id', $cityChurchBaptism->getIdState());
                    $bornDate          = DatabaseManager::databaseDateToSingleDate($baptismBoy->getBornDate());
                    $baptismDate       = DatabaseManager::databaseDateToSingleDate($baptismBoy->getCelebrationDate());
                    $baptismRegistry   = BaptismManager::getSingleBaptismRegistry('id', $baptismBoy->getIdBookRegistry());

                    if ($baptismRegistry === NULL)
                    {
                        $baptismRegistry = new BaptismRegistry();
                    }

                    //Set the Baptism Church
                    $this->SetXY($x+48, $y+121-$cellSizeY);
                    $this->Cell(125, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');

                    //Set the Baptism Church Address
                    $this->SetXY($x+25, $y+127-$cellSizeY);
                    $this->Cell(72, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->geTAddress()), $test, 0, 'C');

                    //Set the Baptism Church City
                    $this->SetXY($x+110, $y+127-$cellSizeY);
                    $this->Cell(85, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchBaptism->getName(). ", " . 
                                                                         $stateTemp->getShortName()), $test, 0, 'C');

                    //Set The day of baptism
                    $this->SetXY($x+31, $y+133-$cellSizeY);
                    $this->Cell(9, $cellSizeY, substr($baptismDate, 0, 2), $test, 0, 'C');

                    //Set The month of baptism
                    $this->SetXY($x+46, $y+133-$cellSizeY);
                    $this->Cell(47, $cellSizeY, $month[intval(substr($baptismDate, 3, 2))-1], $test, 0, 'C');

                    //Set The year of baptism
                    $this->SetXY($x+103, $y+133-$cellSizeY);
                    $this->Cell(10, $cellSizeY, substr($baptismDate, 6), $test, 0, 'C');

                    //Get The Book Registry Book
                    $this->SetXY($x+131, $y+133-$cellSizeY);
                    $this->Cell(12, $cellSizeY, $baptismRegistry->getBook(), $test, 0, 'C');

                    //Get The Book Registry Page
                    $page = $baptismRegistry->getPage();

                    if ($baptismRegistry->getReverse() === 'Y')
                    {
                        $page = $page . "v";
                    }

                    $this->SetXY($x+151, $y+133-$cellSizeY);
                    $this->Cell(12, $cellSizeY, $page, $test, 0, 'C');

                    //Get The Book Registry Number
                    $this->SetXY($x+172, $y+133-$cellSizeY);
                    $this->Cell(12, $cellSizeY, $baptismRegistry->getNumber(), $test, 0, 'C');

                    //Set The day of born
                    $this->SetXY($x+47, $y+139-$cellSizeY);
                    $this->Cell(8, $cellSizeY, substr($bornDate, 0, 2), $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+61, $y+139-$cellSizeY);
                    $this->Cell(43, $cellSizeY, $month[intval(substr($bornDate, 3, 2))-1], $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+116, $y+139-$cellSizeY);
                    $this->Cell(8, $cellSizeY, substr($bornDate, 6), $test, 0, 'C');

                    //Set The born place
                    $this->SetXY($x+130, $y+139-$cellSizeY);
                    $this->Cell(70, $cellSizeY, iconv('utf-8', 'cp1252', $baptismBoy->getBornPlace()), $test, 0, 'C');
                }
                else
                {
                    //Set the Baptism Church
                    $this->SetXY($x+48, $y+121-$cellSizeY);
                    $this->Cell(125, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');

                    //Set the Baptism Church Address
                    $this->SetXY($x+25, $y+127-$cellSizeY);
                    $this->Cell(72, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');

                    //Set the Baptism Church City
                    $this->SetXY($x+110, $y+127-$cellSizeY);
                    $this->Cell(85, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');

                    //Set The day of baptism
                    $this->SetXY($x+31, $y+133-$cellSizeY);
                    $this->Cell(9, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The month of baptism
                    $this->SetXY($x+47, $y+133-$cellSizeY);
                    $this->Cell(47, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The year of baptism
                    $this->SetXY($x+103, $y+133-$cellSizeY);
                    $this->Cell(10, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Book
                    $this->SetXY($x+131, $y+133-$cellSizeY);
                    $this->Cell(12, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Page
                    $this->SetXY($x+152, $y+133-$cellSizeY);
                    $this->Cell(12, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Number
                    $this->SetXY($x+172, $y+133-$cellSizeY);
                    $this->Cell(12, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The day of born
                    $this->SetXY($x+47, $y+139-$cellSizeY);
                    $this->Cell(8, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+61, $y+139-$cellSizeY);
                    $this->Cell(43, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+116, $y+139-$cellSizeY);
                    $this->Cell(8, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The born place
                    $this->SetXY($x+131, $y+139-$cellSizeY);
                    $this->Cell(70, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');   
                }

                //Get the Girlfriend Names
                $this->SetXY($x+47, $y+148-$cellSizeY);
                $this->Cell(68, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');

                //Get the Girlfriend Father
                $this->SetXY($x+132, $y+148-$cellSizeY);
                $this->Cell(68, $cellSizeY, iconv('utf-8', 'cp1252', $fatherGirl->getFullNameBeginName()), $test, 0, 'C');

                //Get the Girlfriend Mother
                $this->SetXY($x+56, $y+154-$cellSizeY);
                $this->Cell(117, $cellSizeY, iconv('utf-8', 'cp1252', $motherGirl->getFullNameBeginName()), $test, 0, 'C');

                if ($baptismGirl !== NULL)
                {
                    //Get the Girlfriend Mother
                    $baptismChurch     = $baptismGirl->getIdChurch();
                    $baptismChurch     = ChurchManager::getSingleChurch('id', $baptismChurch);
                    $cityChurchBaptism = CityManager::getSingleCity('id', $baptismChurch->getIdCity());
                    $stateTemp         = CityManager::getSingleState('id', $cityChurchBaptism->getIdState());
                    $bornDate          = DatabaseManager::databaseDateToSingleDate($baptismGirl->getBornDate());
                    $baptismDate       = DatabaseManager::databaseDateToSingleDate($baptismGirl->getCelebrationDate());
                    $baptismRegistry   = BaptismManager::getSingleBaptismRegistry('id', $baptismGirl->getIdBookRegistry());

                    if ($baptismRegistry === NULL)
                    {
                        $baptismRegistry = new BaptismRegistry();
                    }

                    //Set the Baptism Church
                    $this->SetXY($x+48, $y+160-$cellSizeY);
                    $this->Cell(125, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');

                    //Set the Baptism Church Address
                    $this->SetXY($x+25, $y+166-$cellSizeY);
                    $this->Cell(72, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->geTAddress()), $test, 0, 'C');

                    //Set the Baptism Church City
                    $this->SetXY($x+110, $y+166-$cellSizeY);
                    $this->Cell(85, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchBaptism->getName(). ", " . 
                                                                         $stateTemp->getShortName()), $test, 0, 'C');

                    //Set The day of baptism
                    $this->SetXY($x+31, $y+171-$cellSizeY);
                    $this->Cell(9, $cellSizeY, substr($baptismDate, 0, 2), $test, 0, 'C');

                    //Set The month of baptism
                    $this->SetXY($x+47, $y+171-$cellSizeY);
                    $this->Cell(47, $cellSizeY, $month[intval(substr($baptismDate, 3, 2))-1], $test, 0, 'C');

                    //Set The year of baptism
                    $this->SetXY($x+103, $y+171-$cellSizeY);
                    $this->Cell(10, $cellSizeY, substr($baptismDate, 6), $test, 0, 'C');

                    //Get The Book Registry Book
                    $this->SetXY($x+131, $y+171-$cellSizeY);
                    $this->Cell(12, $cellSizeY, $baptismRegistry->getBook(), $test, 0, 'C');

                    //Get The Book Registry Page
                    $page = $baptismRegistry->getPage();

                    if ($baptismRegistry->getReverse() === 'Y')
                    {
                        $page = $page . "v";
                    }

                    $this->SetXY($x+152, $y+171-$cellSizeY);
                    $this->Cell(12, $cellSizeY, $page, $test, 0, 'C');

                    //Get The Book Registry Number
                    $this->SetXY($x+172, $y+171-$cellSizeY);
                    $this->Cell(12, $cellSizeY, $baptismRegistry->getNumber(), $test, 0, 'C');

                    //Set The day of born
                    $this->SetXY($x+47, $y+177-$cellSizeY);
                    $this->Cell(8, $cellSizeY, substr($bornDate, 0, 2), $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+61, $y+177-$cellSizeY);
                    $this->Cell(43, $cellSizeY, $month[intval(substr($bornDate, 3, 2))-1], $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+116, $y+177-$cellSizeY);
                    $this->Cell(8, $cellSizeY, substr($bornDate, 6), $test, 0, 'C');

                    //Set The born place
                    $this->SetXY($x+130, $y+177-$cellSizeY);
                    $this->Cell(70, $cellSizeY, iconv('utf-8', 'cp1252', $baptismGirl->getBornPlace()), $test, 0, 'C');
                }
                else
                {
                    //Set the Baptism Church
                    $this->SetXY($x+48, $y+160-$cellSizeY);
                    $this->Cell(125, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');

                    //Set the Baptism Church Address
                    $this->SetXY($x+25, $y+166-$cellSizeY);
                    $this->Cell(72, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');

                    //Set the Baptism Church City
                    $this->SetXY($x+110, $y+166-$cellSizeY);
                    $this->Cell(85, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');

                    //Set The day of baptism
                    $this->SetXY($x+31, $y+171-$cellSizeY);
                    $this->Cell(9, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The month of baptism
                    $this->SetXY($x+47, $y+171-$cellSizeY);
                    $this->Cell(47, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The year of baptism
                    $this->SetXY($x+103, $y+171-$cellSizeY);
                    $this->Cell(10, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Book
                    $this->SetXY($x+131, $y+171-$cellSizeY);
                    $this->Cell(12, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Page
                    $this->SetXY($x+152, $y+171-$cellSizeY);
                    $this->Cell(12, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Number
                    $this->SetXY($x+172, $y+171-$cellSizeY);
                    $this->Cell(12, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The day of born
                    $this->SetXY($x+47, $y+177-$cellSizeY);
                    $this->Cell(8, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+61, $y+177-$cellSizeY);
                    $this->Cell(43, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+116, $y+177-$cellSizeY);
                    $this->Cell(8, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The born place
                    $this->SetXY($x+130, $y+177-$cellSizeY);
                    $this->Cell(70, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');   
                }

                //Set The church of marriage
                $this->SetXY($x+26, $y+197-$cellSizeY);
                $this->Cell(130, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getName()), $test, 0, 'C');

                //Get the Current Location
                $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+26, $y+247-$cellSizeY);
                $this->Cell(79, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                //Get The Current Day
                $this->SetXY($x+109, $y+247-$cellSizeY);
                $this->Cell(7, $cellSizeY, date("d"), $test, 0, 'C');

                //Get The Current Month
                $this->SetXY($x+122, $y+247-$cellSizeY);
                $this->Cell(32, $cellSizeY, $month[intval(date("m"))-1], $test, 0, 'C');

                //Get The Current Year
                $this->SetXY($x+159, $y+247-$cellSizeY);
                $this->Cell(11, $cellSizeY, date('Y'), $test, 0, 'C');
            }
            else
            {
                //Set The Rector Marriage
                $this->SetXY($x+46, $y+41-$cellSizeY);
                $this->Cell(118, $cellSizeY, iconv('utf-8', 'cp1252', $rectorMarriage->getPosition() . " " . 
                                                                      $rectorMarriageP->getFullNameBeginName()), $test, 0, 'C');

                //Get the Boyfriend Names
                $this->SetXY($x+47, $y+47-$cellSizeY);
                $this->Cell(70, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getFullNameBeginName()), $test, 0, 'C');

                //Get the 'y'
                $this->SetXY($x+117, $y+47-$cellSizeY);
                $this->Cell(7, $cellSizeY, 'y', $test, 0, 'C');

                //Get the Girlfriend Names
                $this->SetXY($x+124, $y+47-$cellSizeY);
                $this->Cell(70, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');

                //Get user Church Marriage Name 
                $this->SetXY($x+44, $y+53-$cellSizeY);
                $this->Cell(97, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getName()), $test, 0, 'C');

                //Set The day of Marriage
                $this->SetXY($x+152, $y+53-$cellSizeY);
                $this->Cell(7, $cellSizeY, substr($celebrationDate, 0, 2), $test, 0, 'C');

                //Set The month of Marriage
                $this->SetXY($x+164, $y+53-$cellSizeY);
                $this->Cell(30, $cellSizeY, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

                //Set The Rector Marriage
                $this->SetXY($x+68, $y+86-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $rectorMarriage->getPosition() . " " . 
                                                                     $rectorMarriageP->getFullNameBeginName()), $test, 0, 'C');

                //Get the Boyfriend Names
                $this->SetXY($x+35, $y+121-$cellSizeY);
                $this->Cell(67, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getFullNameBeginName()), $test, 0, 'C');

                //Get the Girlfriend Names
                $this->SetXY($x+114, $y+121-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');

                //Set The Witness1
                $this->SetXY($x+35, $y+149-$cellSizeY);
                $this->Cell(67, $cellSizeY, iconv('utf-8', 'cp1252', $witness1->getFullNameBeginName()), $test, 0, 'C');

                //Set The Witness2
                $this->SetXY($x+114, $y+149-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $witness2->getFullNameBeginName()), $test, 0, 'C');

                //Set The Godfather
                $this->SetXY($x+35, $y+176-$cellSizeY);
                $this->Cell(67, $cellSizeY, iconv('utf-8', 'cp1252', $godFather->getFullNameBeginName()), $test, 0, 'C');

                //Set The Godmother
                $this->SetXY($x+114, $y+176-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $godMother->getFullNameBeginName()), $test, 0, 'C');

                //Get The Rector from the user
                $this->SetXY($x+74, $y+199-$cellSizeY);
                $this->Cell(68, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
            }
        }
        // Footer
        function Footer()
        {
            $userChurch = $this->user->getIdChurch();
            $userChurch = ChurchManager::getSingleChurch('id', $userChurch);

            $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
            $rectorUserP = $rectorUser->getPosition();
            $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

            $this->SetFont('Arial','B', 10);
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSizeY = 5;
            $test = 0;
            
            if ($this->full == 'true')
            {
                $x = 0;
                $y = 0;
            }
            else
            {
                $x = intval($paperConfig->getMarriageCertX());
                $y = intval($paperConfig->getMarriageCertY());
            }

            if ($this->type == 'no-reverse')
            {
                //Get The Rector from the user
                $this->SetXY($x+70, $y+270-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
            }
            else
            {
                //Get The Rector from the user
                $this->SetXY($x+70, $y+264-$cellSizeY);
                $this->Cell(85, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
            }
        }

        /**
        * Gets the value of marriage.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriage()
        {
            return $this->marriage;
        }
         
        /**
        * Sets the value of marriage.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriage the marriage
        */
        public function setMarriage($marriage)
        {
            $this->marriage = $marriage;
        }
         
        /**
        * Gets the value of user.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getUser()
        {
            return $this->user;
        }
         
        /**
        * Sets the value of user.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $user the user
        */
        public function setUser($user)
        {
            $this->user = $user;
        }
         
        /**
        * Gets the value of full.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getFull()
        {
            return $this->full;
        }
         
        /**
        * Sets the value of full.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $full the full
        */
        public function setFull($full)
        {
            $this->full = $full;
        }
         
        /**
        * Gets the value of type.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getType()
        {
            return $this->type;
        }
         
        /**
        * Sets the value of type.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $type the type
        */
        public function setType($type)
        {
            $this->type = $type;
        }
    }
 ?>
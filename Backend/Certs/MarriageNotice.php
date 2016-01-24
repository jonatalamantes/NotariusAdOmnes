<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Marriage Notice
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class MarriageNotice extends FPDF
    {
        private $marriage;
        private $user;
        private $full;
        private $type;
        private $owner;

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
            if ($full == 'true')
            {
                parent::FPDF('L', 'mm', array(215,140));
            }
            else
            {
                parent::FPDF('P', 'mm', 'Letter');
            }

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

            $marriageChurch = $this->marriage->getIdChurchMarriage();
            $marriageChurch = ChurchManager::getSingleChurch('id', $marriageChurch);
            $cityChurchMarriage = CityManager::getSingleCity('id', $marriageChurch->getIdCity());

            $processChurch = $this->marriage->getIdChurchProcess();
            $processChurch = ChurchManager::getSingleChurch('id', $processChurch);

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->marriage->getCelebrationDate());

            $boyfriend  = PersonManager::getSinglePerson('id', $this->marriage->getIdBoyfriend());
            $girlfriend = PersonManager::getSinglePerson('id', $this->marriage->getIdGirlfriend());

            if ($this->owner == 'boyfriend')
            {
                $myOwner = $boyfriend;
            }
            else
            {
                $myOwner = $girlfriend;
            }

            $father = PersonManager::getSinglePerson('id', $myOwner->getIdFather());

            if ($father === NULL)
            {
                $father = new Person(0, '*****************');
            }

            $mother = PersonManager::getSinglePerson('id', $myOwner->getIdMother());

            if ($mother === NULL)
            {
                $mother = new Person(0, '*****************');
            }

            //Get the baptism of the boyfriend
            $baptism = BaptismManager::getSingleBaptism('idOwner', $myOwner->getId());

            //Get the marriage Registry 
            $marriageRegistry   = MarriageManager::getSingleMarriageRegistry('id', $this->marriage->getIdBookRegistry());

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
                    $this->Image(__DIR__."/../../Backend/Certs/img/marriageNotice1.jpg", $x, $y, 215, 140);    
                }
                else
                {
                    $this->Image(__DIR__."/../../Backend/Certs/img/marriageNotice2.jpg", $x, $y, 215, 140);
                }
            }
            else
            {
                $x = intval($paperConfig->getMarriageNoticeX());
                $y = intval($paperConfig->getMarriageNoticeY());    
            }

            //Put the data of the Notice
            if ($this->type == 'no-reverse')
            {
                $this->SetFont('Arial','B', 7);

                //Get user Church Name 
                $this->SetXY($x+10, $y+42-$cellSizeY);
                $this->Cell(40, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

                //Get user Church Address 
                $this->SetXY($x+10, $y+49-$cellSizeY);
                $this->Cell(40, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

                //Get user Church City 
                $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+10, $y+52-$cellSizeY);
                $this->Cell(40, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                $this->SetFont('Arial','B', 9);

                if ($baptism !== NULL)
                {
                    $baptismChurch     = $baptism->getIdChurch();
                    $baptismChurch     = ChurchManager::getSingleChurch('id', $baptismChurch);
                    $cityChurchBaptism = CityManager::getSingleCity('id', $baptismChurch->getIdCity());
                    $stateTemp         = CityManager::getSingleState('id', $cityChurchBaptism->getIdState());
                    $bornDate          = DatabaseManager::databaseDateToSingleDate($baptism->getBornDate());
                    $baptismRegistry   = BaptismManager::getSingleBaptismRegistry('id', $baptism->getIdBookRegistry());

                    if ($baptismRegistry === NULL)
                    {
                        $baptismRegistry = new BaptismRegistry();
                    }

                    //Set the Church of Baptism
                    $this->SetXY($x+77, $y+43-$cellSizeY);
                    $this->Cell(68, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');                

                    //Set the City of Baptism
                    $this->SetXY($x+150, $y+43-$cellSizeY);
                    $this->Cell(57, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchBaptism->getName(). ", " . 
                                                                         $stateTemp->getShortName()), $test, 0, 'C');

                    //Set the Church of the Marriage
                    $this->SetXY($x+149, $y+50-$cellSizeY);
                    $this->Cell(58, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getName()), $test, 0, 'C');                

                    //Set the Boyfriend
                    $this->SetXY($x+89, $y+56-$cellSizeY);
                    $this->Cell(118, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getFullNameBeginName()), $test, 0, 'C');

                    //Set the Boyfriend
                    $this->SetXY($x+53, $y+62-$cellSizeY);
                    $this->Cell(78, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');

                    //Set The day of marriage
                    $this->SetXY($x+141, $y+62-$cellSizeY);
                    $this->Cell(7, $cellSizeY, substr($celebrationDate, 0, 2), $test, 0, 'C');

                    //Set The month of marriage
                    $this->SetXY($x+153, $y+62-$cellSizeY);
                    $this->Cell(35, $cellSizeY, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

                    //Set The year of marriage
                    $this->SetXY($x+195, $y+62-$cellSizeY);
                    $this->Cell(12, $cellSizeY, substr($celebrationDate, 6), $test, 0, 'C');

                    if ($myOwner->getGender() === 'F')
                    {
                        //Set The Gender
                        $this->SetXY($x+50, $y+69-$cellSizeY);
                        $this->Cell(7, $cellSizeY, 'La', $test, 0, 'C');

                        $this->SetXY($x+90, $y+69-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'a', $test, 0, 'C');

                        $this->SetXY($x+195, $y+69-$cellSizeY);
                        $this->Cell(12, $cellSizeY, 'a', $test, 0, 'C');

                        $this->SetXY($x+62, $y+75-$cellSizeY);
                        $this->Cell(4, $cellSizeY, 'a', $test, 0, 'C');

                        $this->SetXY($x+143, $y+82-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'a', $test, 0, 'C');
                    }
                    else
                    {
                        //Set The Gender
                        $this->SetXY($x+50, $y+69-$cellSizeY);
                        $this->Cell(7, $cellSizeY, 'El', $test, 0, 'C');

                        $this->SetXY($x+90, $y+69-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'o', $test, 0, 'C');

                        $this->SetXY($x+195, $y+69-$cellSizeY);
                        $this->Cell(12, $cellSizeY, 'o', $test, 0, 'C');

                        $this->SetXY($x+62, $y+75-$cellSizeY);
                        $this->Cell(4, $cellSizeY, 'o', $test, 0, 'C');

                        $this->SetXY($x+143, $y+82-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'o', $test, 0, 'C');
                    }

                    //Set the born place
                    $this->SetXY($x+100, $y+69-$cellSizeY);
                    $this->Cell(88, $cellSizeY, iconv('utf-8', 'cp1252', $baptism->getBornPlace()), $test, 0, 'C');

                    //Set The Father
                    $this->SetXY($x+72, $y+75-$cellSizeY);
                    $this->Cell(67, $cellSizeY, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');

                    //Set The Middle
                    $this->SetXY($x+139, $y+75-$cellSizeY);
                    $this->Cell(5, $cellSizeY, iconv('utf-8', 'cp1252', 'y'), $test, 0, 'C');

                    //Set The Mother
                    $this->SetXY($x+144, $y+75-$cellSizeY);
                    $this->Cell(63, $cellSizeY, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');

                    //Set The Born Date
                    $this->SetXY($x+72, $y+82-$cellSizeY);
                    $this->Cell(47, $cellSizeY, iconv('utf-8', 'cp1252', $bornDate), $test, 0, 'C');

                    //Get The Book Registry Book
                    $this->SetXY($x+65, $y+88-$cellSizeY);
                    $this->Cell(21, $cellSizeY, $baptismRegistry->getBook(), $test, 0, 'C');

                    //Get The Book Registry Page
                    $page = $baptismRegistry->getPage();

                    if ($baptismRegistry->getReverse() === 'Y')
                    {
                        $page = $page . "v";
                    }

                    $this->SetXY($x+101, $y+88-$cellSizeY);
                    $this->Cell(21, $cellSizeY, $page, $test, 0, 'C');

                    //Get The Book Registry Number
                    $this->SetXY($x+137, $y+88-$cellSizeY);
                    $this->Cell(21, $cellSizeY, $baptismRegistry->getNumber(), $test, 0, 'C');
                }                
                else
                {
                    //Set the Church of Baptism
                    $this->SetXY($x+77, $y+43-$cellSizeY);
                    $this->Cell(68, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture el Bautizo Primero'), $test, 0, 'C');                

                    //Set the City of Baptism
                    $this->SetXY($x+150, $y+43-$cellSizeY);
                    $this->Cell(57, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture el Bautizo Primero'), $test, 0, 'C');

                    //Set the Church of the Marriage
                    $this->SetXY($x+149, $y+50-$cellSizeY);
                    $this->Cell(58, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture el Bautizo Primero'), $test, 0, 'C');                

                    //Set the Boyfriend
                    $this->SetXY($x+89, $y+56-$cellSizeY);
                    $this->Cell(118, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getFullNameBeginName()), $test, 0, 'C');

                    //Set the Boyfriend
                    $this->SetXY($x+53, $y+62-$cellSizeY);
                    $this->Cell(78, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');

                    //Set The day of marriage
                    $this->SetXY($x+141, $y+62-$cellSizeY);
                    $this->Cell(7, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The month of marriage
                    $this->SetXY($x+153, $y+62-$cellSizeY);
                    $this->Cell(35, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The year of marriage
                    $this->SetXY($x+195, $y+62-$cellSizeY);
                    $this->Cell(12, $cellSizeY, 'X', $test, 0, 'C');

                    if ($myOwner->getGender() === 'F')
                    {
                        //Set The Gender
                        $this->SetXY($x+50, $y+69-$cellSizeY);
                        $this->Cell(7, $cellSizeY, 'La', $test, 0, 'C');

                        $this->SetXY($x+90, $y+69-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'a', $test, 0, 'C');

                        $this->SetXY($x+195, $y+69-$cellSizeY);
                        $this->Cell(12, $cellSizeY, 'a', $test, 0, 'C');

                        $this->SetXY($x+62, $y+75-$cellSizeY);
                        $this->Cell(4, $cellSizeY, 'a', $test, 0, 'C');

                        $this->SetXY($x+143, $y+82-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'a', $test, 0, 'C');
                    }
                    else
                    {
                        //Set The Gender
                        $this->SetXY($x+50, $y+69-$cellSizeY);
                        $this->Cell(7, $cellSizeY, 'El', $test, 0, 'C');

                        $this->SetXY($x+90, $y+69-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'o', $test, 0, 'C');

                        $this->SetXY($x+195, $y+69-$cellSizeY);
                        $this->Cell(12, $cellSizeY, 'o', $test, 0, 'C');

                        $this->SetXY($x+62, $y+75-$cellSizeY);
                        $this->Cell(4, $cellSizeY, 'o', $test, 0, 'C');

                        $this->SetXY($x+143, $y+82-$cellSizeY);
                        $this->Cell(5, $cellSizeY, 'o', $test, 0, 'C');
                    }

                    //Set the born place
                    $this->SetXY($x+100, $y+69-$cellSizeY);
                    $this->Cell(88, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture el Bautizo Primero'), $test, 0, 'C');

                    //Set The Father
                    $this->SetXY($x+72, $y+75-$cellSizeY);
                    $this->Cell(67, $cellSizeY, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');

                    //Set The Middle
                    $this->SetXY($x+139, $y+75-$cellSizeY);
                    $this->Cell(5, $cellSizeY, iconv('utf-8', 'cp1252', 'y'), $test, 0, 'C');

                    //Set The Mother
                    $this->SetXY($x+144, $y+75-$cellSizeY);
                    $this->Cell(63, $cellSizeY, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');

                    //Set The Born Date
                    $this->SetXY($x+72, $y+82-$cellSizeY);
                    $this->Cell(47, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture el Bautizo Primero'), $test, 0, 'C');

                    //Get The Book Registry Book
                    $this->SetXY($x+65, $y+88-$cellSizeY);
                    $this->Cell(21, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Page
                    $this->SetXY($x+101, $y+88-$cellSizeY);
                    $this->Cell(21, $cellSizeY, 'X', $test, 0, 'C');

                    //Get The Book Registry Number
                    $this->SetXY($x+137, $y+88-$cellSizeY);
                    $this->Cell(21, $cellSizeY, 'X', $test, 0, 'C');
                }
                
                //Get process Church Name 
                $this->SetXY($x+88, $y+103-$cellSizeY);
                $this->Cell(119, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                //Get process Church Address 
                $this->SetXY($x+66, $y+110-$cellSizeY);
                $this->Cell(72, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getAddress()), $test, 0, 'C');

                //Get process Church City 
                $cityTemp   = CityManager::getSingleCity('id', $processChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                //Get the city of the process
                $this->SetXY($x+148, $y+110-$cellSizeY);
                $this->Cell(59, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                //Get the 'Expediente'
                $page = $marriageRegistry->getPage();

                if ($marriageRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }

                $stringExp = $marriageRegistry->getBook() . ", " . $page . ", " . $marriageRegistry->getNumber(); 
                $this->SetXY($x+86, $y+117-$cellSizeY);
                $this->Cell(20, $cellSizeY, iconv('utf-8', 'cp1252', $stringExp), $test, 0, 'L');
            }
            else
            {
                if ($this->owner == 'boyfriend')
                {
                    $myOwner = $boyfriend;
                }
                else
                {
                    $myOwner = $girlfriend;
                }

                //Get the baptism of the boyfriend
                $baptism = BaptismManager::getSingleBaptism('idOwner', $myOwner->getId());

                //Get The Process church
                $processChurch = $this->marriage->getIdChurchProcess();
                $processChurch = ChurchManager::getSingleChurch('id', $processChurch);

                if ($baptism !== NULL)
                {
                    $baptismChurch     = $baptism->getIdChurch();
                    $baptismChurch     = ChurchManager::getSingleChurch('id', $baptismChurch);
                    $cityChurchBaptism = CityManager::getSingleCity('id', $baptismChurch->getIdCity());
                    $stateTemp         = CityManager::getSingleState('id', $cityChurchBaptism->getIdState());
                    $baptismRegistry   = BaptismManager::getSingleBaptismRegistry('id', $baptism->getIdBookRegistry());

                    if ($baptismRegistry === NULL)
                    {
                        $baptismRegistry = new BaptismRegistry();
                    }

                    //Set the Church of Baptism
                    $this->SetXY($x+86, $y+41-$cellSizeY);
                    $this->Cell(65, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');                

                    //Set the City of Baptism
                    $this->SetXY($x+157, $y+41-$cellSizeY);
                    $this->Cell(42, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchBaptism->getName(). ", " . 
                                                                         $stateTemp->getShortName()), $test, 0, 'C');

                    //Set The Baptism Book
                    $this->SetXY($x+147, $y+58-$cellSizeY);
                    $this->Cell(7, $cellSizeY, iconv('utf-8', 'cp1252', $baptismRegistry->getBook()), $test, 0, 'C');
                }
                else
                {
                    //Set the Church of Baptism
                    $this->SetXY($x+86, $y+41-$cellSizeY);
                    $this->Cell(65, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture el Bautizo Primero'), $test, 0, 'C');                

                    //Set the City of Baptism
                    $this->SetXY($x+157, $y+41-$cellSizeY);
                    $this->Cell(42, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture el Bautizo Primero'), $test, 0, 'C');

                    //Set The Baptism Book
                    $this->SetXY($x+147, $y+58-$cellSizeY);
                    $this->Cell(7, $cellSizeY, iconv('utf-8', 'cp1252', 'X'), $test, 0, 'C');   
                }

                //Get process Church Name 
                $this->SetXY($x+63, $y+77-$cellSizeY);
                $this->Cell(72, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                //Get process Church City 
                $cityTemp   = CityManager::getSingleCity('id', $processChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+140, $y+77-$cellSizeY);
                $this->Cell(60, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                //Get The Current Day
                $this->SetXY($x+121, $y+96-$cellSizeY);
                $this->Cell(7, $cellSizeY, date("d"), $test, 0, 'C');

                //Get The Current Month
                $this->SetXY($x+133, $y+96-$cellSizeY);
                $this->Cell(48, $cellSizeY, $month[intval(date("m"))-1], $test, 0, 'C');

                //Get The Current Year
                $this->SetXY($x+187, $y+96-$cellSizeY);
                $this->Cell(13, $cellSizeY, date('Y'), $test, 0, 'C');
            }
        }
        // Footer
        function Footer()
        {
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
                $x = intval($paperConfig->getMarriageNoticeX());
                $y = intval($paperConfig->getMarriageNoticeY());    
            }

            if ($this->type == 'reverse')
            {
                $userChurch = $this->user->getIdChurch();
                $userChurch = ChurchManager::getSingleChurch('id', $userChurch);

                $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
                $rectorUserP = $rectorUser->getPosition();
                $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

                $this->SetFont('Arial','B', 10);

                //Get the Current Location
                $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+72, $y+123-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                //Get The Current Date
                $this->SetXY($x+152, $y+123-$cellSizeY);
                $this->Cell(20, $cellSizeY, date('d/m/Y'), $test, 0, 'C');

                //Get The Rector from the user
                $this->SetXY($x+130, $y+136-$cellSizeY);
                $this->Cell(76, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
            }
            else
            {
                $userChurch = $this->user->getIdChurch();
                $userChurch = ChurchManager::getSingleChurch('id', $userChurch);

                $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
                $rectorUserP = $rectorUser->getPosition();
                $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

                $this->SetFont('Arial','B', 10);
            
                //Get The Rector from the user
                $this->SetXY($x+130, $y+126-$cellSizeY);
                $this->Cell(76, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
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
         
        /**
        * Gets the value of owner.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getOwner()
        {
            return $this->owner;
        }
         
        /**
        * Sets the value of owner.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $owner the owner
        */
        public function setOwner($owner)
        {
            $this->owner = $owner;
        }
    }
 ?>
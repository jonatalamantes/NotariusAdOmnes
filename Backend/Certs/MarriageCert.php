<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Marriage Cert
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class MarriageCert extends FPDF
    {
        private $marriage;
        private $user;
        private $full;

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
     
                $this->Image(__DIR__."/../../Backend/Certs/img/marriageCert.jpg", $x, $y+5, 217, 270);
            }
            else
            {
                $x = intval($paperConfig->getMarriageCertX());
                $y = intval($paperConfig->getMarriageCertY());
            }

            //Put the data of the Cert
            $this->SetFont('Arial','B', 7);

            //Get user Church Name 
            $this->SetXY($x+12, $y+65-$cellSizeY);
            $this->Cell(48, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get user Church Address 
            $this->SetXY($x+12, $y+72-$cellSizeY);
            $this->Cell(48, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

            //Get user Church City 
            $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

            $this->SetXY($x+12, $y+75-$cellSizeY);
            $this->Cell(48, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            $this->SetFont('Arial','B', 9);

            //Get The Rector from the user
            $this->SetXY($x+63, $y+90-$cellSizeY);
            $this->Cell(140, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');

            //Get user Church Name 
            $this->SetXY($x+69, $y+99-$cellSizeY);
            $this->Cell(134, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get The Book Registry Book
            $this->SetXY($x+147, $y+110-$cellSizeY);
            $this->Cell(47, $cellSizeY, $marriageRegistry->getBook(), $test, 0, 'C');

            //Get The Book Registry Page
            $page = $marriageRegistry->getPage();

            if ($marriageRegistry->getReverse() === 'Y')
            {
                $page = $page . "v";
            }

            $this->SetXY($x+38, $y+118-$cellSizeY);
            $this->Cell(25, $cellSizeY, $page, $test, 0, 'C');

            //Get The Book Registry Number
            $this->SetXY($x+98, $y+118-$cellSizeY);
            $this->Cell(27, $cellSizeY, $marriageRegistry->getNumber(), $test, 0, 'C');

            //Set The Name of the Boyfriend
            $this->SetXY($x+30, $y+126-$cellSizeY);
            $this->Cell(174, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getFullNameBeginName()), $test, 0, 'C');

            //Set The Name of the Girlfriend
            $this->SetXY($x+31, $y+134-$cellSizeY);
            $this->Cell(173, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');

            //Get user Church City 
            $stateTemp  = CityManager::getSingleState('id', $cityChurchMarriage->getIdState());

            $this->SetXY($x+62, $y+143-$cellSizeY);
            $this->Cell(50, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchMarriage->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Set The day of marriage
            $this->SetXY($x+126, $y+143-$cellSizeY);
            $this->Cell(7, $cellSizeY, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of marriage
            $this->SetXY($x+141, $y+143-$cellSizeY);
            $this->Cell(42, $cellSizeY, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of marriage
            $this->SetXY($x+190, $y+143-$cellSizeY);
            $this->Cell(10, $cellSizeY, substr($celebrationDate, 6), $test, 0, 'C');

            //Set The church of marriage
            $this->SetXY($x+50, $y+151-$cellSizeY);
            $this->Cell(154, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getName()), $test, 0, 'C');

            //Get The Marriage Rector
            $this->SetXY($x+80, $y+159-$cellSizeY);
            $this->Cell(124, $cellSizeY, iconv('utf-8', 'cp1252', $rectorMarriage->getPosition() . " " . 
                                                                  $rectorMarriageP->getFullNameBeginName()), $test, 0, 'C');

            //Set The Witness1
            $this->SetXY($x+54, $y+168-$cellSizeY);
            $this->Cell(150, $cellSizeY, iconv('utf-8', 'cp1252', $witness1->getFullNameBeginName()), $test, 0, 'C');

            //Set The Witness2
            $this->SetXY($x+21, $y+176-$cellSizeY);
            $this->Cell(183, $cellSizeY, iconv('utf-8', 'cp1252', $witness2->getFullNameBeginName()), $test, 0, 'C');

            //Set The Godfather
            $this->SetXY($x+47, $y+185-$cellSizeY);
            $this->Cell(157, $cellSizeY, iconv('utf-8', 'cp1252', $godFather->getFullNameBeginName()), $test, 0, 'C');

            //Set The Godmother
            $this->SetXY($x+21, $y+193-$cellSizeY);
            $this->Cell(183, $cellSizeY, iconv('utf-8', 'cp1252', $godMother->getFullNameBeginName()), $test, 0, 'C');

            //Get user Church Process Name 
            $this->SetXY($x+21, $y+209-$cellSizeY);
            $this->Cell(183, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurchProcess->getName()), $test, 0, 'C');

            //Get user Church Process City 
            $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

            $this->SetXY($x+29, $y+218-$cellSizeY);
            $this->Cell(48, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Get The Current Day
            $this->SetXY($x+88, $y+218-$cellSizeY);
            $this->Cell(11, $cellSizeY, date("d"), $test, 0, 'C');

            //Get The Current Month
            $this->SetXY($x+133, $y+218-$cellSizeY);
            $this->Cell(35, $cellSizeY, $month[intval(date("m"))-1], $test, 0, 'C');

            //Get The Current Year
            $this->SetXY($x+193, $y+218-$cellSizeY);
            $this->Cell(9, $cellSizeY, date('Y'), $test, 0, 'C');
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

            //Get The Rector from the user
            $this->SetXY($x+117, $y+273-$cellSizeY);
            $this->Cell(76, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
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
        * @param mixed $marriage the marriage
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
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
        * @param mixed $user the user
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
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
        * @param mixed $full the full
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setFull($full)
        {
            $this->full = $full;
        }
    }
 ?>
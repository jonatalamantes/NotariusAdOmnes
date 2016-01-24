<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Marriage Constancy
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class MarriageConstancy extends FPDF
    {
        private $marriage;
        private $user;
        private $full;

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
                parent::FPDF('L', 'mm', array(215, 140));    
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

            //Config the document 
            $this->SetFont('Arial','B', 9);
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSizeY = 5;
            $test = 0;

            if ($this->full == 'true')
            {
                $x = 0;
                $y = 0;
            
                $this->Image(__DIR__."/../../Backend/Certs/img/marriageConstancy.jpg", $x, $y, 215, 140);
            }
            else
            {
                $x = intval($paperConfig->getMarriageConstancyX());
                $y = intval($paperConfig->getMarriageConstancyY());
            }

            //Put the data of the Constancy

            //Set The Name of the Boyfriend
            $this->SetXY($x+67, $y+37-$cellSizeY);
            $this->Cell(140, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getFullNameBeginName()), $test, 0, 'C');

            //Set The Name of the Girlfriend
            $this->SetXY($x+67, $y+43-$cellSizeY);
            $this->Cell(140, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');

            $this->SetFont('Arial','B', 7);

            //Get user Church Name 
            $this->SetXY($x+5, $y+54-$cellSizeY);
            $this->Cell(43, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get user Church Address 
            $this->SetXY($x+5, $y+65-$cellSizeY);
            $this->Cell(43, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

            //Get user Church City 
            $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

            $this->SetXY($x+5, $y+70-$cellSizeY);
            $this->Cell(43, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            $this->SetFont('Arial','B', 9);

            //Get The Marriage Rector
            $this->SetXY($x+67, $y+61-$cellSizeY);
            $this->Cell(140, $cellSizeY, iconv('utf-8', 'cp1252', $rectorMarriage->getPosition() . " " . 
                                                                  $rectorMarriageP->getFullNameBeginName()), $test, 0, 'C');

            //Set The church of marriage
            $this->SetXY($x+62, $y+67-$cellSizeY);
            $this->Cell(145, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurch->getName()), $test, 0, 'C');

            //Set The Witness1
            $this->SetXY($x+64, $y+74-$cellSizeY);
            $this->Cell(143, $cellSizeY, iconv('utf-8', 'cp1252', $witness1->getFullNameBeginName()), $test, 0, 'C');

            //Set The Witness2
            $this->SetXY($x+50, $y+80-$cellSizeY);
            $this->Cell(157, $cellSizeY, iconv('utf-8', 'cp1252', $witness2->getFullNameBeginName()), $test, 0, 'C');

            //Set The Godfather
            $this->SetXY($x+64, $y+87-$cellSizeY);
            $this->Cell(69, $cellSizeY, iconv('utf-8', 'cp1252', $godFather->getFullNameBeginName()), $test, 0, 'C');

            $this->SetXY($x+133, $y+87-$cellSizeY);
            $this->Cell(5, $cellSizeY, iconv('utf-8', 'cp1252', 'y'), $test, 0, 'C');

            //Set The Godmother
            $this->SetXY($x+138, $y+87-$cellSizeY);
            $this->Cell(69, $cellSizeY, iconv('utf-8', 'cp1252', $godMother->getFullNameBeginName()), $test, 0, 'C');

            //Get user Church Address 
            $this->SetXY($x+73, $y+93-$cellSizeY);
            $this->Cell(70, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

            //Get user Church City 
            $stateTemp  = CityManager::getSingleState('id', $cityChurchMarriage->getIdState());

            $this->SetXY($x+143, $y+93-$cellSizeY);
            $this->Cell(40, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchMarriage->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            $this->SetXY($x+183, $y+93-$cellSizeY);
            $this->Cell(24, $cellSizeY, iconv('utf-8', 'cp1252', $celebrationDate), $test, 0, 'C');

            //Get user Church Process Name 
            $this->SetXY($x+97, $y+100-$cellSizeY);
            $this->Cell(110, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurchProcess->getName()), $test, 0, 'C');

            //Get user Church Process Address 
            $this->SetXY($x+78, $y+107-$cellSizeY);
            $this->Cell(85, $cellSizeY, iconv('utf-8', 'cp1252', $marriageChurchProcess->getAddress()), $test, 0, 'C');

            //Get user Church Process City 
            $stateTemp  = CityManager::getSingleState('id', $cityChurchProcess->getIdState());

            $this->SetXY($x+163, $y+107-$cellSizeY);
            $this->Cell(44, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

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
                $x = intval($paperConfig->getMarriageConstancyX());
                $y = intval($paperConfig->getMarriageConstancyY());
            }
            
            //Get The Rector from the user
            $this->SetXY($x+150, $y+135-$cellSizeY);
            $this->Cell(57, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
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